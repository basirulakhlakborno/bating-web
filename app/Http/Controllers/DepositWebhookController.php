<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Referral\ReferralCommissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Server-to-server deposit confirmation (payment gateway / internal orchestration).
 * Sign with HMAC-SHA256 of raw body using DEPOSIT_WEBHOOK_SECRET; send header X-Webhook-Signature: hex digest.
 */
class DepositWebhookController extends Controller
{
    public function __construct(
        private ReferralCommissionService $referralCommission,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (! filter_var(config('referral.deposit.webhook_enabled', true), FILTER_VALIDATE_BOOLEAN)) {
            return response()->json(['message' => 'Webhook disabled.'], 503);
        }

        $secret = (string) config('referral.deposit.webhook_secret');
        if ($secret === '') {
            Log::warning('referral.deposit.webhook_missing_secret');

            return response()->json(['message' => 'Webhook not configured.'], 503);
        }

        $raw = $request->getContent();
        $sig = (string) $request->header('X-Webhook-Signature', '');
        $expected = hash_hmac('sha256', $raw, $secret);

        if ($sig === '' || ! hash_equals($expected, $sig)) {
            return response()->json(['message' => 'Invalid signature.'], 401);
        }

        $payload = $request->json()->all();
        $validated = validator($payload, [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency_code' => ['required', 'string', 'size:3'],
            'reference' => ['required', 'string', 'max:64'],
        ])->validate();

        $amount = number_format((float) $validated['amount'], 2, '.', '');
        $max = (float) config('referral.deposit.max_amount', 10000000);
        if ((float) $amount > $max) {
            return response()->json(['message' => 'Amount exceeds limit.'], 422);
        }

        /** @var User $user */
        $user = User::query()->findOrFail($validated['user_id']);

        $deposit = $this->referralCommission->recordConfirmedDeposit(
            $user,
            $amount,
            strtoupper($validated['currency_code']),
            $validated['reference']
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
