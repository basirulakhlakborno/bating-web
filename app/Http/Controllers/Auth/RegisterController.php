<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        ]);

        $typed = strtolower(trim($validated['captcha']));
        $expected = $request->session()->pull('register_captcha_hash');
        if (! $expected || ! hash_equals($expected, hash('sha256', $typed))) {
            throw ValidationException::withMessages([
                'captcha' => ['ভেরিফিকেশন কোড সঠিক নয়। অনুগ্রহ করে নতুন কোড দিয়ে আবার চেষ্টা করুন।'],
            ]);
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

        Auth::login($user);

        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('Registration complete.'),
                'redirect' => url('/'),
            ]);
        }

        return redirect('/');
    }
}
