<?php

namespace App\Support\Referral;

use App\Models\User;
use App\Models\UserDeposit;
use App\Models\UserReferralLedgerEntry;
use App\Models\UserReferralTier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralCommissionService
{
    public function __construct(
        private ReferralDataService $referralData,
    ) {}

    /**
     * Record a confirmed deposit: credit member wallet, upline commissions (5 depth levels),
     * optional ৳2000 milestone bonus (BDT). Idempotent when {@see $reference} repeats for the same user.
     */
    public function recordConfirmedDeposit(User $depositor, string $amount, string $currencyCode, ?string $reference = null, ?array $meta = null): UserDeposit
    {
        $reference = $this->normalizeReference($reference);

        return DB::transaction(function () use ($depositor, $amount, $currencyCode, $reference, $meta) {
            /** @var User $depositor */
            $depositor = User::query()->lockForUpdate()->findOrFail($depositor->id);

            if ($reference !== null) {
                $existing = UserDeposit::query()
                    ->where('user_id', $depositor->id)
                    ->where('reference', $reference)
                    ->first();
                if ($existing !== null) {
                    Log::info('referral.deposit.idempotent_skip', [
                        'user_id' => $depositor->id,
                        'deposit_id' => $existing->id,
                        'reference' => $reference,
                    ]);

                    return $existing;
                }
            }

            $deposit = UserDeposit::query()->create([
                'user_id' => $depositor->id,
                'amount' => $amount,
                'currency_code' => strtoupper($currencyCode),
                'status' => 'confirmed',
                'reference' => $reference,
                'meta' => is_array($meta) ? $meta : [],
            ]);

            $depositor->increment('balance', $amount);

            $this->referralData->ensureTiers($depositor);

            $bonusCurrency = strtoupper((string) config('referral.bonus_currency', 'BDT'));
            $prevBdtTotal = (string) UserDeposit::query()
                ->where('user_id', $depositor->id)
                ->where('status', 'confirmed')
                ->where('currency_code', $bonusCurrency)
                ->where('id', '!=', $deposit->id)
                ->sum('amount');

            $this->payoutUplineCommissions($depositor, $amount, strtoupper($currencyCode), $deposit->id);

            $bdtAdded = strtoupper($currencyCode) === $bonusCurrency ? $amount : '0';
            $newBdtTotal = $this->addMoney($prevBdtTotal, $bdtAdded);

            $depositor->refresh();
            $this->maybePayMilestoneBonus($depositor, $prevBdtTotal, $newBdtTotal);

            Log::info('referral.deposit.recorded', [
                'user_id' => $depositor->id,
                'deposit_id' => $deposit->id,
                'amount' => $amount,
                'currency' => strtoupper($currencyCode),
                'reference' => $reference,
            ]);

            return $deposit;
        });
    }

    private function normalizeReference(?string $reference): ?string
    {
        if ($reference === null) {
            return null;
        }
        $t = trim($reference);

        return $t === '' ? null : $t;
    }

    private function payoutUplineCommissions(User $depositor, string $depositAmount, string $currencyCode, int $depositId): void
    {
        $defs = config('referral.tier_definitions', []);
        $parentId = $depositor->referred_by;
        $level = 0;

        while ($parentId !== null && $level < count($defs)) {
            /** @var User|null $parent */
            $parent = User::query()->lockForUpdate()->find($parentId);
            if ($parent === null) {
                break;
            }

            $this->referralData->ensureTiers($parent);

            $rate = (float) ($defs[$level]['rate_percent'] ?? 0);
            $slug = (string) ($defs[$level]['slug'] ?? 'direct');
            $commission = $this->percentOf($depositAmount, $rate);

            if ($this->compareMoney($commission, '0') > 0) {
                $parent->increment('balance', $commission);

                UserReferralLedgerEntry::query()->create([
                    'user_id' => $parent->id,
                    'source' => 'commission',
                    'title' => $this->commissionTitle($level),
                    'amount' => $commission,
                    'currency_code' => $currencyCode,
                    'occurred_on' => now()->toDateString(),
                    'meta' => [
                        'tier_slug' => $slug,
                        'from_user_id' => $depositor->id,
                        'deposit_id' => $depositId,
                        'rate_percent' => $rate,
                    ],
                ]);

                UserReferralTier::query()
                    ->where('user_id', $parent->id)
                    ->where('slug', $slug)
                    ->increment('amount', $commission);
            }

            $parentId = $parent->referred_by;
            $level++;
        }
    }

    private function maybePayMilestoneBonus(User $depositor, string $prevTotal, string $newTotal): void
    {
        /** @var User|null $depositor */
        $depositor = User::query()->lockForUpdate()->find($depositor->id);
        if ($depositor === null) {
            return;
        }

        $threshold = (string) config('referral.deposit_threshold_for_bonus', '2000');
        $bonusCurrency = strtoupper((string) config('referral.bonus_currency', 'BDT'));

        if (strtoupper((string) $depositor->currency_code) !== $bonusCurrency) {
            return;
        }

        if ($depositor->referral_milestone_bonus_at !== null) {
            return;
        }

        if ($depositor->referred_by === null) {
            return;
        }

        if ($this->compareMoney($prevTotal, $threshold) >= 0) {
            return;
        }

        if ($this->compareMoney($newTotal, $threshold) < 0) {
            return;
        }

        $refBonus = (string) config('referral.bonus_to_referee', '500');
        $refInvBonus = (string) config('referral.bonus_to_referrer', '500');

        /** @var User|null $referrer */
        $referrer = User::query()->lockForUpdate()->find($depositor->referred_by);
        if ($referrer === null) {
            return;
        }

        $this->referralData->ensureTiers($referrer);
        $this->referralData->ensureTiers($depositor);

        $referrer->increment('balance', $refInvBonus);
        $depositor->increment('balance', $refBonus);
        $depositor->forceFill(['referral_milestone_bonus_at' => now()])->save();

        UserReferralLedgerEntry::query()->create([
            'user_id' => $referrer->id,
            'source' => 'bonus',
            'title' => 'রেফারেল মাইলফলক বোনাস (বন্ধু ৳২০০০ জমা)',
            'amount' => $refInvBonus,
            'currency_code' => $bonusCurrency,
            'occurred_on' => now()->toDateString(),
            'meta' => ['kind' => 'milestone_2000', 'referee_id' => $depositor->id],
        ]);

        UserReferralLedgerEntry::query()->create([
            'user_id' => $depositor->id,
            'source' => 'bonus',
            'title' => 'রেফারেল মাইলফলক বোনাস (নিবন্ধন বন্ধুর মাধ্যমে)',
            'amount' => $refBonus,
            'currency_code' => $bonusCurrency,
            'occurred_on' => now()->toDateString(),
            'meta' => ['kind' => 'milestone_2000', 'referrer_id' => $referrer->id],
        ]);
    }

    private function percentOf(string $amount, float $ratePercent): string
    {
        if (function_exists('bcmul') && function_exists('bcdiv')) {
            return bcdiv(bcmul($amount, (string) $ratePercent, 4), '100', 2);
        }

        return number_format(((float) $amount) * $ratePercent / 100, 2, '.', '');
    }

    private function addMoney(string $a, string $b): string
    {
        if (function_exists('bcadd')) {
            return bcadd($a, $b, 2);
        }

        return number_format((float) $a + (float) $b, 2, '.', '');
    }

    /** @return int -1, 0, or 1 */
    private function compareMoney(string $a, string $b): int
    {
        if (function_exists('bccomp')) {
            return bccomp($a, $b, 2);
        }

        return (float) $a <=> (float) $b;
    }

    private function commissionTitle(int $level): string
    {
        return match ($level) {
            0 => 'রেফারেল কমিশন (সরাসরি)',
            1 => 'রেফারেল কমিশন (স্তর ১)',
            2 => 'রেফারেল কমিশন (স্তর ২)',
            3 => 'রেফারেল কমিশন (স্তর ৩)',
            default => 'রেফারেল কমিশন (স্তর ৪)',
        };
    }
}
