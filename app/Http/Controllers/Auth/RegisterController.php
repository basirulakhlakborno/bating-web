<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\JwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z0-9_\-.]+$/', 'unique:users,username'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'phone' => ['required', 'string', 'max:32'],
            'currency' => ['required', 'string', 'in:BDT,INR,NPR,PKR'],
            'terms_accepted' => ['accepted'],
            'captcha' => ['required', 'string', 'max:32'],
            'referral_code' => ['nullable', 'string', 'max:64', 'regex:/^[a-zA-Z0-9_\-.]+$/'],
        ]);

        $typed = strtolower(trim($validated['captcha']));
        $expected = $request->session()->pull('register_captcha_hash');
        if (! $expected || ! hash_equals($expected, hash('sha256', $typed))) {
            throw ValidationException::withMessages([
                'captcha' => ['ভেরিফিকেশন কোড সঠিক নয়। অনুগ্রহ করে নতুন কোড দিয়ে আবার চেষ্টা করুন।'],
            ]);
        }

        $referrerId = null;
        $refCode = isset($validated['referral_code']) ? trim((string) $validated['referral_code']) : '';
        if ($refCode !== '') {
            $normalized = strtolower($refCode);
            /** @var User|null $referrer */
            $referrer = User::query()
                ->whereRaw('LOWER(referral_code) = ?', [$normalized])
                ->first();
            if ($referrer === null) {
                $referrer = User::query()
                    ->whereRaw('LOWER(username) = ?', [$normalized])
                    ->first();
            }
            if ($referrer === null) {
                throw ValidationException::withMessages([
                    'referral_code' => ['এই রেফারেল কোড পাওয়া যায়নি।'],
                ]);
            }
            $referrerId = $referrer->getKey();
        }

        $domain = config('auth.player_email_domain', 'players.local');

        $user = User::query()->create([
            'name' => $validated['username'],
            'username' => $validated['username'],
            'email' => strtolower($validated['username']).'@'.$domain,
            'phone' => $validated['phone'],
            'currency_code' => $validated['currency'],
            'locale' => 'bn',
            'role' => 'user',
            'password' => $validated['password'],
        ]);

        if ($referrerId !== null && (int) $referrerId !== (int) $user->getKey()) {
            $user->forceFill(['referred_by' => $referrerId])->save();
        }

        Auth::login($user);

        $request->session()->regenerate();

        if ($request->expectsJson()) {
            $ttl = (int) env('JWT_TTL_MINUTES', 120);
            $token = JwtToken::issue([
                'sub' => (string) $user->getAuthIdentifier(),
                'username' => (string) $user->username,
                'role' => (string) ($user->role ?? 'user'),
                'email' => (string) ($user->email ?? ''),
                'name' => (string) ($user->name ?? ''),
                'phone' => (string) ($user->phone ?? ''),
                'balance' => (string) ($user->balance ?? '0'),
                'currency_code' => (string) ($user->currency_code ?? 'BDT'),
                'currency_symbol' => $user->currencySymbol(),
            ], $ttl);

            return response()->json([
                'message' => 'নিবন্ধন সম্পন্ন হয়েছে।',
                'redirect' => url('/'),
                'token_type' => 'Bearer',
                'expires_in' => $ttl * 60,
                'token' => $token,
                'user' => User::query()->with('referrer')->findOrFail($user->getKey())->toApiArray(),
            ]);
        }

        return redirect('/');
    }
}
