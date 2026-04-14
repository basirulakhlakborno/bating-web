<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\JwtToken;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private function userPayload(?Authenticatable $user): array
    {
        if (! $user) {
            return [];
        }

        /** @var \App\Models\User $u */
        $u = $user;

        return User::query()->with('referrer')->findOrFail($u->getKey())->toApiArray();
    }

    public function login(Request $request): RedirectResponse|JsonResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:64'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => ['এই তথ্য দিয়ে কোনো অ্যাকাউন্ট পাওয়া যায়নি।'],
            ]);
        }

        $request->session()->regenerate();
        $redirectUrl = $request->session()->pull('url.intended', url('/'));

        if ($request->expectsJson()) {
            $user = $request->user();
            $ttl = (int) env('JWT_TTL_MINUTES', 120);
            $token = JwtToken::issue([
                'sub' => (string) $user?->getAuthIdentifier(),
                'username' => (string) ($user?->username ?? ''),
                'role' => (string) ($user?->role ?? 'user'),
                'email' => (string) ($user?->email ?? ''),
                'name' => (string) ($user?->name ?? ''),
                'phone' => (string) ($user?->phone ?? ''),
                'balance' => (string) ($user?->balance ?? '0'),
                'currency_code' => (string) ($user?->currency_code ?? 'BDT'),
                'currency_symbol' => (string) ($user instanceof \App\Models\User ? $user->currencySymbol() : '৳'),
            ], $ttl);

            return response()->json([
                'message' => 'সফলভাবে লগইন হয়েছে।',
                'redirect' => $redirectUrl,
                'token_type' => 'Bearer',
                'expires_in' => $ttl * 60,
                'token' => $token,
                'user' => $this->userPayload($user),
            ]);
        }

        return redirect()->to($redirectUrl);
    }

    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'সফলভাবে লগআউট হয়েছে।',
                'redirect' => url('/'),
            ]);
        }

        return redirect('/');
    }
}
