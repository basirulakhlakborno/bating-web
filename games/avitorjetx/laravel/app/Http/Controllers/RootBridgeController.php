<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Support\BridgeJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RootBridgeController extends Controller
{
    /**
     * Accepts ?token= JWT from main site, provisions local user + wallet, sets session.
     */
    public function consume(Request $request)
    {
        $token = (string) $request->query('token', '');
        if ($token === '') {
            return redirect()->to($this->mainLoginUrl());
        }

        $payload = BridgeJwt::decode($token);
        if ($payload === null) {
            return redirect()->to($this->mainLoginUrl())->with('bridge_error', 'invalid_token');
        }

        $sub = (string) ($payload['sub'] ?? '');
        $username = (string) ($payload['username'] ?? '');
        if ($sub === '' || $username === '') {
            return redirect()->to($this->mainLoginUrl())->with('bridge_error', 'bad_payload');
        }

        $emailRaw = trim((string) ($payload['email'] ?? ''));
        $email = $emailRaw !== '' ? $emailRaw : ($username.'@players.bridge');
        $name = (string) ($payload['name'] ?? $username);
        $phone = trim((string) ($payload['phone'] ?? ''));
        $mobile = $phone !== '' ? $phone : ('u'.$sub);
        $balance = (string) ($payload['balance'] ?? '0');
        $currencySymbol = trim((string) ($payload['currency_symbol'] ?? ''));
        if ($currencySymbol === '') {
            $currencySymbol = match (strtoupper(trim((string) ($payload['currency_code'] ?? '')))) {
                'INR' => '₹',
                'PKR' => '₨',
                'NPR' => 'Rs',
                default => '৳',
            };
        }

        $user = User::query()->where('email', $email)->orWhere('mobile', $mobile)->first();
        if ($user === null) {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->mobile = $mobile;
            $user->password = Hash::make(Str::random(32));
            $user->currency = $currencySymbol;
            $user->gender = 'male';
            $user->country = 'BD';
            $user->promocode = '';
            $user->save();
        } else {
            $user->name = $name;
            $user->currency = $currencySymbol;
            $user->save();
        }

        $wallet = Wallet::query()->where('userid', (string) $user->id)->first();
        if ($wallet === null) {
            $wallet = new Wallet;
            $wallet->userid = (string) $user->id;
        }
        $wallet->amount = $balance;
        $wallet->save();

        $request->session()->regenerate();
        $request->session()->put('userlogin', $user);

        $next = (string) $request->query('redirect', '/crash');
        if ($next === '' || ! str_starts_with($next, '/')) {
            $next = '/crash';
        }

        /*
         * Use an absolute URL for this app’s public path. A relative Location like `/crash`
         * resolves to http://localhost/crash and breaks XAMPP subdirectory installs
         * (e.g. /games/avitorjetx/laravel/public/...).
         */
        return $this->redirectToAppPath($request, $next);
    }

    private function redirectToAppPath(Request $request, string $path): \Illuminate\Http\RedirectResponse
    {
        $path = '/'.ltrim($path, '/');
        $script = str_replace('\\', '/', (string) $request->server->get('SCRIPT_NAME', ''));
        $base = $script !== '' ? dirname($script) : '';
        $base = str_replace('\\', '/', $base);
        if ($base === '/' || $base === '.' || $base === '\\') {
            $base = '';
        }
        $url = rtrim($request->getSchemeAndHttpHost().$base, '/').$path;

        return redirect()->to($url, 302)
            ->header('Cache-Control', 'private, no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    private function mainLoginUrl(): string
    {
        $base = rtrim((string) config('services.root_app.url', ''), '/');
        $path = (string) config('services.root_app.login_path', '/login');

        return $base !== '' ? $base.$path : '/';
    }
}
