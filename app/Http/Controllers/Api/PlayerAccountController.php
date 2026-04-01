<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\ResolvesJwtUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDeposit;
use App\Models\UserWithdrawal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PlayerAccountController extends Controller
{
    use ResolvesJwtUser;

    public function me(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $fresh = User::query()->with('referrer')->findOrFail($user->id);

        return response()->json(['user' => $fresh->toApiArray()]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if (! Hash::check($validated['current_password'], (string) $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['বর্তমান গোপন নম্বর সঠিক নয়।'],
            ]);
        }

        $user->forceFill([
            'password' => $validated['password'],
        ])->save();

        Log::info('player.password_changed', ['user_id' => $user->id]);

        return response()->json(['message' => 'পাসওয়ার্ড আপডেট হয়েছে।']);
    }

    /** Inbox / notices — extend with DB later; empty by default. */
    public function inbox(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $messages = [];
        $notices = [];

        return response()->json([
            'messages' => $messages,
            'notices' => $notices,
            'unread_count' => $this->countInboxUnread($messages, $notices),
        ]);
    }

    /**
     * @param  list<array<string, mixed>>  $messages
     * @param  list<array<string, mixed>>  $notices
     */
    private function countInboxUnread(array $messages, array $notices): int
    {
        $n = 0;
        foreach ($messages as $row) {
            if (! is_array($row)) {
                continue;
            }
            if (! (bool) ($row['read'] ?? false)) {
                $n++;
            }
        }
        foreach ($notices as $row) {
            if (! is_array($row)) {
                continue;
            }
            if (! (bool) ($row['read'] ?? false)) {
                $n++;
            }
        }

        return $n;
    }

    public function withdraw(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'method' => ['required', 'string', 'max:32'],
            'account_phone' => ['nullable', 'string', 'max:32'],
            'reference' => ['nullable', 'string', 'max:64'],
        ]);

        $currency = strtoupper($validated['currency_code'] ?? (string) ($user->currency_code ?: 'BDT'));
        $amount = number_format((float) $validated['amount'], 2, '.', '');
        $reference = isset($validated['reference']) && trim((string) $validated['reference']) !== ''
            ? trim((string) $validated['reference'])
            : 'wd-'.bin2hex(random_bytes(8));

        return DB::transaction(function () use ($user, $amount, $currency, $validated, $reference): JsonResponse {
            /** @var User $locked */
            $locked = User::query()->lockForUpdate()->findOrFail($user->id);

            $existing = UserWithdrawal::query()
                ->where('user_id', $locked->id)
                ->where('reference', $reference)
                ->first();
            if ($existing !== null) {
                return response()->json([
                    'message' => 'পূর্বেই প্রক্রিয়াজাত।',
                    'balance' => (string) ($locked->balance ?? '0.00'),
                    'idempotent' => true,
                ]);
            }

            if (function_exists('bccomp')) {
                if (bccomp((string) $locked->balance, $amount, 2) < 0) {
                    throw ValidationException::withMessages([
                        'amount' => ['অপর্যাপ্ত ব্যালেন্স।'],
                    ]);
                }
            } elseif ((float) $locked->balance < (float) $amount) {
                throw ValidationException::withMessages([
                    'amount' => ['অপর্যাপ্ত ব্যালেন্স।'],
                ]);
            }

            $locked->decrement('balance', $amount);

            UserWithdrawal::query()->create([
                'user_id' => $locked->id,
                'amount' => $amount,
                'currency_code' => $currency,
                'method' => $validated['method'],
                'account_phone' => $validated['account_phone'] ?? null,
                'status' => 'completed',
                'reference' => $reference,
                'meta' => [],
            ]);

            $locked->refresh();

            return response()->json([
                'message' => 'উত্তোলন অনুরোধ সম্পন্ন হয়েছে।',
                'balance' => (string) ($locked->balance ?? '0.00'),
                'idempotent' => false,
            ]);
        });
    }

    public function bankHistory(Request $request): JsonResponse
    {
        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $from = $validated['from'] ?? null;
        $to = $validated['to'] ?? null;

        $depositsQuery = UserDeposit::query()->where('user_id', $user->id)->where('status', 'confirmed');
        $withdrawalsQuery = UserWithdrawal::query()->where('user_id', $user->id);

        if ($from) {
            $depositsQuery->whereDate('created_at', '>=', $from);
            $withdrawalsQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $depositsQuery->whereDate('created_at', '<=', $to);
            $withdrawalsQuery->whereDate('created_at', '<=', $to);
        }

        $deposits = $depositsQuery->orderByDesc('created_at')->limit(200)->get()->map(fn (UserDeposit $d) => [
            'id' => $d->id,
            'kind' => 'deposit',
            'created_at' => $d->created_at?->toIso8601String(),
            'amount' => number_format((float) $d->amount, 2, '.', ''),
            'currency_code' => $d->currency_code,
            'reference' => $d->reference,
            'status' => $d->status,
            'method' => is_array($d->meta) ? ($d->meta['ewallet'] ?? $d->meta['channel'] ?? '—') : '—',
            'channel' => is_array($d->meta) ? ($d->meta['channel'] ?? '—') : '—',
            'bonus' => '0.00',
            'remark' => '',
        ]);

        $withdrawals = $withdrawalsQuery->orderByDesc('created_at')->limit(200)->get()->map(fn (UserWithdrawal $w) => [
            'id' => $w->id,
            'kind' => 'withdrawal',
            'created_at' => $w->created_at?->toIso8601String(),
            'amount' => number_format((float) $w->amount, 2, '.', ''),
            'currency_code' => $w->currency_code,
            'reference' => $w->reference,
            'status' => $w->status,
            'method' => $w->method,
            'account_phone' => $w->account_phone,
        ]);

        return response()->json([
            'deposits' => $deposits,
            'withdrawals' => $withdrawals,
        ]);
    }
}
