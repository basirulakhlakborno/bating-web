<?php

namespace App\Support\Referral;

use App\Models\User;
use App\Models\UserReferralLedgerEntry;
use App\Models\UserReferralTier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReferralDataService
{
    /**
     * Existing accounts created before referral_code existed may have NULL; assign once.
     */
    private function ensureUserHasReferralCode(User $user): void
    {
        $current = $user->getAttribute('referral_code');
        if ($current !== null && $current !== '') {
            return;
        }

        $user->referral_code = User::generateUniqueReferralCode();
        $user->saveQuietly();
    }

    public function ensureTiers(User $user): void
    {
        $defs = config('referral.tier_definitions', []);
        foreach ($defs as $position => $def) {
            $slug = (string) ($def['slug'] ?? 'tier_'.$position);
            $label = $slug === 'direct'
                ? $user->publicReferralCode()
                : (string) ($def['label'] ?? '');
            $rate = (float) ($def['rate_percent'] ?? 0);

            $tier = UserReferralTier::query()
                ->where('user_id', $user->id)
                ->where('position', $position)
                ->first();

            if ($tier === null) {
                UserReferralTier::query()->create([
                    'user_id' => $user->id,
                    'position' => $position,
                    'slug' => $slug,
                    'label' => $label,
                    'rate_percent' => $rate,
                    'amount' => 0,
                    'is_active' => $position === 0,
                ]);

                continue;
            }

            if ($slug === 'direct' && $tier->label !== $label) {
                $tier->label = $label;
                $tier->save();
            }
        }
    }

    /**
     * @return array{meta: array<string, mixed>, tiers: list<array<string, mixed>>, summary: array<string, mixed>, report: array<string, mixed>, history: array<string, mixed>}
     */
    public function snapshot(User $user): array
    {
        $this->ensureUserHasReferralCode($user);
        $this->ensureTiers($user);
        $user->load(['referralTiers']);

        $currency = strtoupper((string) $user->currency_code) ?: 'BDT';
        $symbol = $user->currencySymbol();

        $code = $user->publicReferralCode();
        $tiers = $user->referralTiers->map(fn (UserReferralTier $t) => [
            'slug' => $t->slug,
            'label' => $t->slug === 'direct' ? $code : $t->label,
            'rate_percent' => (float) $t->rate_percent,
            'amount' => $this->formatMoney($t->amount),
            'active' => (bool) $t->is_active,
        ])->values()->all();

        $commissionOnly = UserReferralLedgerEntry::query()
            ->where('user_id', $user->id)
            ->where('source', 'commission')
            ->sum('amount');

        $bonusTotal = UserReferralLedgerEntry::query()
            ->where('user_id', $user->id)
            ->where('source', 'bonus')
            ->sum('amount');

        $referralIncomeTotal = (float) $commissionOnly + (float) $bonusTotal;

        $summary = [
            'currency_code' => $currency,
            'currency_symbol' => $symbol,
            'total_commission' => $this->formatMoney($commissionOnly),
            'total_bonus' => $this->formatMoney($bonusTotal),
            'total_referral_income' => $this->formatMoney($referralIncomeTotal),
            'tier_count' => count($tiers),
            'pending_settlement' => $this->formatMoney(0),
            'last_settled_at' => null,
        ];

        $reportDays = (int) config('referral.report_days', 30);
        $from = Carbon::now()->subDays($reportDays)->startOfDay();

        $reportRows = UserReferralLedgerEntry::query()
            ->where('user_id', $user->id)
            ->whereIn('source', ['commission', 'bonus'])
            ->where('created_at', '>=', $from)
            ->select([
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as cnt'),
                DB::raw('SUM(amount) as total'),
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(fn ($r) => [
                'date' => $r->day,
                'entries' => (int) $r->cnt,
                'commission' => $this->formatMoney($r->total ?? 0),
            ])
            ->values()
            ->all();

        $report = [
            'period_days' => $reportDays,
            'currency_code' => $currency,
            'rows' => $reportRows,
            'period_total' => $this->formatMoney(
                UserReferralLedgerEntry::query()
                    ->where('user_id', $user->id)
                    ->whereIn('source', ['commission', 'bonus'])
                    ->where('created_at', '>=', $from)
                    ->sum('amount')
            ),
        ];

        $historyLimit = (int) config('referral.history_limit', 50);
        $historyRows = UserReferralLedgerEntry::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($historyLimit)
            ->get()
            ->map(fn (UserReferralLedgerEntry $e) => [
                'id' => $e->id,
                'source' => $e->source,
                'title' => $e->title,
                'amount' => $this->formatMoney($e->amount),
                'currency_code' => $e->currency_code,
                'occurred_on' => $e->occurred_on?->format('Y-m-d'),
                'created_at' => $e->created_at?->toIso8601String(),
            ])
            ->values()
            ->all();

        $history = [
            'limit' => $historyLimit,
            'rows' => $historyRows,
        ];

        return [
            'meta' => [
                'title_bn' => (string) config('referral.title_bn', 'রেফারেল প্রোগ্রাম'),
                'description_bn' => (string) config('referral.description_bn', ''),
                'referral_code' => $code,
                'share_url' => null,
            ],
            'tiers' => $tiers,
            'summary' => $summary,
            'report' => $report,
            'history' => $history,
        ];
    }

    private function formatMoney(mixed $value): string
    {
        return number_format((float) $value, 2, '.', '');
    }
}
