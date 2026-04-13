<?php

use App\Http\Middleware\CacheHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request): string {
            if ($request->is('hakai/admin') || $request->is('hakai/admin/*')) {
                return route('admin.login');
            }

            return route('login');
        });
        $middleware->validateCsrfTokens(except: [
            'login',
            'api/login',
            'logout',
            'register',
            'register/captcha',
            'csrf-token',
            'api/deposit',
            'api/webhooks/deposit',
            'api/me',
            'api/profile/password',
            'api/inbox',
            'api/bank/withdraw',
            'api/bank/history',
        ]);
        $middleware->append(CacheHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
