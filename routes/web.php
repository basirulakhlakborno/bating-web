<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterAdminController;
use App\Http\Controllers\Admin\GameAdminController;
use App\Http\Controllers\Admin\NavigationAdminController;
use App\Http\Controllers\Admin\SiteSettingAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterCaptchaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\PlayerAccountController;
use App\Http\Controllers\DepositApiController;
use App\Http\Controllers\ReferralApiController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| JSON/HTML auth & registration (AJAX from React: Accept: application/json)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:auth-login')->group(function (): void {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/api/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware(['auth', 'throttle:auth-logout'])
    ->name('logout');

Route::middleware('throttle:api-captcha')->group(function (): void {
    Route::get('/register/captcha', [RegisterCaptchaController::class, 'image'])->name('register.captcha');
});

Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:auth-register');

Route::middleware('throttle:api-player-read')->group(function (): void {
    Route::get('/api/me', [PlayerAccountController::class, 'me']);
    Route::get('/api/inbox', [PlayerAccountController::class, 'inbox']);
    Route::get('/api/referral', [ReferralApiController::class, 'show']);
    Route::get('/api/bank/history', [PlayerAccountController::class, 'bankHistory']);
});

Route::post('/api/profile/password', [PlayerAccountController::class, 'changePassword'])
    ->middleware('throttle:api-player-write');

Route::post('/api/bank/withdraw', [PlayerAccountController::class, 'withdraw'])
    ->middleware('throttle:api-withdraw');

Route::post('/api/deposit', [DepositApiController::class, 'store'])->middleware('throttle:deposit-jwt');
Route::post('/api/webhooks/deposit', \App\Http\Controllers\DepositWebhookController::class)->middleware('throttle:deposit-webhook');

Route::get('/csrf-token', static fn () => response()->json(['csrfToken' => csrf_token()]))
    ->middleware('throttle:api-csrf')
    ->name('csrf.token');

/*
|--------------------------------------------------------------------------
| Player SPA (Vite build → public/dist)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:spa-html')->group(function (): void {
    Route::get('/', SpaController::class)->name('home');
    Route::get('/login', SpaController::class)->name('login');
    Route::get('/register', SpaController::class)->name('register');
});

/*
| Profile SPA routes are served like other player pages (JWT in SPA, not Laravel session).
| Do not wrap in `auth` middleware or JWT-only users get redirected on refresh/deep link.
*/

Route::middleware(['auth', 'admin', 'throttle:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('games', GameAdminController::class)->except(['show']);
    Route::get('navigation', [NavigationAdminController::class, 'index'])->name('navigation.index');
    Route::get('navigation/{item}/edit', [NavigationAdminController::class, 'edit'])->name('navigation.edit');
    Route::put('navigation/{item}', [NavigationAdminController::class, 'update'])->name('navigation.update');
    Route::get('footer', [FooterAdminController::class, 'index'])->name('footer.index');
    Route::get('footer/sections/{section}/items/create', [FooterAdminController::class, 'createItem'])->name('footer.items.create');
    Route::post('footer/sections/{section}/items', [FooterAdminController::class, 'storeItem'])->name('footer.items.store');
    Route::get('footer/items/{footerItem}/edit', [FooterAdminController::class, 'editItem'])->name('footer.items.edit');
    Route::put('footer/items/{footerItem}', [FooterAdminController::class, 'updateItem'])->name('footer.items.update');
    Route::get('settings', [SiteSettingAdminController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingAdminController::class, 'update'])->name('settings.update');
    Route::get('users', [UserAdminController::class, 'index'])->name('users.index');
    Route::post('users/{user}/role', [UserAdminController::class, 'updateRole'])->name('users.role');
});

Route::fallback(SpaController::class)->middleware('throttle:spa-html');
