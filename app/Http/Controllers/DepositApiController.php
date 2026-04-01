<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesJwtUser;
use App\Http\Requests\StoreDepositRequest;
use App\Support\Referral\ReferralCommissionService;
use Illuminate\Http\JsonResponse;

/**
 * JWT deposit (dev/sandbox only). Production should use {@see DepositWebhookController}.
 */
class DepositApiController extends Controller
{
    use ResolvesJwtUser;

    public function __construct(
        private ReferralCommissionService $referralCommission,
    ) {}

    public function store(StoreDepositRequest $request): JsonResponse
    {
        if (! filter_var(config('referral.deposit.jwt_enabled', false), FILTER_VALIDATE_BOOLEAN)) {
            return response()->json([
                'message' => 'JWT deposit API is disabled. Use the payment gateway webhook (POST /api/webhooks/deposit) in production.',
            ], 403);
        }

        $user = $this->resolveBearerUser($request);
        if ($user === null) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validated();
        $currency = strtoupper($validated['currency_code'] ?? ((string) ($user->currency_code ?: 'BDT')));
        $amount = number_format((float) $validated['amount'], 2, '.', '');

        $meta = isset($validated['meta']) && is_array($validated['meta']) ? $validated['meta'] : null;

        $deposit = $this->referralCommission->recordConfirmedDeposit(
            $user,
            $amount,
            $currency,
            $validated['reference'] ?? null,
            $meta
        );

        $user->refresh();

        return response()->json([
            'message' => 'আমানত নিশ্চিত হয়েছে।',
            'deposit_id' => $deposit->id,
            'balance' => (string) ($user->balance ?? '0.00'),
            'idempotent' => ! ($deposit->wasRecentlyCreated ?? false),
        ]);
    }
}
