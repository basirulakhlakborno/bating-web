<?php

namespace App\Providers;

use App\Services\SiteLayoutData;
use App\Support\JwtToken;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Shared MySQL (utf8mb4): varchar(255) unique/primary indexes exceed legacy 1000-byte limit — use 191.
        Schema::defaultStringLength(191);

        RedirectIfAuthenticated::redirectUsing(function (Request $request): string {
            if ($request->is('hakai/admin/login')) {
                return route('admin.dashboard');
            }

            return '/';
        });

        $this->registerRateLimiters();

        View::composer(
            [
                'components.desktop-nav',
                'components.navigation-drawer',
                'components.footer',
                'home',
            ],
            function ($view): void {
                static $payload = null;
                $payload ??= SiteLayoutData::shared();
                $view->with($payload);
            }
        );
    }

    /**
     * Throttle key: JWT `sub` when Bearer token is valid, else client IP.
     */
    private static function jwtOrIpKey(Request $request, string $prefix): string
    {
        $header = (string) $request->header('Authorization', '');
        if (preg_match('/^Bearer\s+(\S+)/i', $header, $matches)) {
            $payload = JwtToken::decode($matches[1]);
            if (is_array($payload) && isset($payload['sub']) && $payload['sub'] !== '' && $payload['sub'] !== null) {
                return $prefix.':u:'.(string) $payload['sub'];
            }
        }

        return $prefix.':ip:'.$request->ip();
    }

    private function registerRateLimiters(): void
    {
        if ($this->app->environment('testing')) {
            foreach ([
                'auth-login',
                'auth-register',
                'api-captcha',
                'api-csrf',
                'auth-logout',
                'api-player-read',
                'api-player-write',
                'api-withdraw',
                'spa-html',
                'admin',
                'deposit-jwt',
                'deposit-webhook',
            ] as $name) {
                RateLimiter::for($name, static fn () => Limit::none());
            }

            return;
        }

        RateLimiter::for('auth-login', function (Request $request): Limit {
            $n = max(3, (int) config('rate_limiting.login_per_minute', 12));

            return Limit::perMinute($n)->by('login:'.$request->ip());
        });

        RateLimiter::for('auth-register', function (Request $request): Limit {
            $n = max(2, (int) config('rate_limiting.register_per_minute', 8));

            return Limit::perMinute($n)->by('register:'.$request->ip());
        });

        RateLimiter::for('api-captcha', function (Request $request): Limit {
            $n = max(15, (int) config('rate_limiting.captcha_per_minute', 45));

            return Limit::perMinute($n)->by('captcha:'.$request->ip());
        });

        RateLimiter::for('api-csrf', function (Request $request): Limit {
            $n = max(30, (int) config('rate_limiting.csrf_per_minute', 120));

            return Limit::perMinute($n)->by('csrf:'.$request->ip());
        });

        RateLimiter::for('auth-logout', function (Request $request): Limit {
            $n = max(10, (int) config('rate_limiting.logout_per_minute', 40));
            $uid = $request->user()?->getAuthIdentifier();

            return Limit::perMinute($n)->by('logout:'.($uid !== null ? 'u:'.$uid : 'ip:'.$request->ip()));
        });

        RateLimiter::for('api-player-read', function (Request $request): Limit {
            $key = self::jwtOrIpKey($request, 'api-read');
            $isUser = str_contains($key, ':u:');
            $n = $isUser
                ? max(60, (int) config('rate_limiting.api_read_per_user_minute', 300))
                : max(30, (int) config('rate_limiting.api_read_per_ip_minute', 180));

            return Limit::perMinute($n)->by($key);
        });

        RateLimiter::for('api-player-write', function (Request $request): Limit {
            $key = self::jwtOrIpKey($request, 'api-write');
            $isUser = str_contains($key, ':u:');
            $n = $isUser
                ? max(12, (int) config('rate_limiting.api_write_per_user_minute', 45))
                : max(8, (int) config('rate_limiting.api_write_per_ip_minute', 24));

            return Limit::perMinute($n)->by($key);
        });

        RateLimiter::for('api-withdraw', function (Request $request): Limit {
            $key = self::jwtOrIpKey($request, 'withdraw');
            $isUser = str_contains($key, ':u:');
            $n = $isUser
                ? max(8, (int) config('rate_limiting.api_withdraw_per_user_minute', 36))
                : max(6, (int) config('rate_limiting.api_withdraw_per_ip_minute', 24));

            return Limit::perMinute($n)->by($key);
        });

        RateLimiter::for('spa-html', function (Request $request): Limit {
            $n = max(60, (int) config('rate_limiting.spa_html_per_minute', 300));

            return Limit::perMinute($n)->by('spa:'.$request->ip());
        });

        RateLimiter::for('admin', function (Request $request): Limit {
            $n = max(120, (int) config('rate_limiting.admin_per_minute', 400));
            $uid = $request->user('admin')?->getAuthIdentifier();

            return Limit::perMinute($n)->by('admin:'.($uid !== null ? 'u:'.$uid : 'ip:'.$request->ip()));
        });

        RateLimiter::for('deposit-jwt', function (Request $request): Limit {
            $per = max(1, (int) config('referral.deposit.throttle_per_minute', 30));
            $key = self::jwtOrIpKey($request, 'deposit-jwt');

            return Limit::perMinute($per)->by($key);
        });

        RateLimiter::for('deposit-webhook', function (Request $request): Limit {
            $n = max(60, (int) config('rate_limiting.deposit_webhook_per_minute', 600));

            return Limit::perMinute($n)->by('wh-deposit:'.$request->ip());
        });
    }
}
