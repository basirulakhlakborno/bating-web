<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterAdminController;
use App\Http\Controllers\Admin\GameAdminController;
use App\Http\Controllers\Admin\GameCategoryAdminController;
use App\Http\Controllers\Admin\HomeCricketMatchAdminController;
use App\Http\Controllers\Admin\MediaAssetAdminController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\Admin\NavigationAdminController;
use App\Http\Controllers\Admin\PaymentMethodAdminController;
use App\Http\Controllers\Admin\SiteSettingAdminController;
use App\Http\Controllers\Admin\SocialLinkAdminController;
use App\Http\Controllers\Admin\TransactionAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Api\PlayerAccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterCaptchaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DepositApiController;
use App\Http\Controllers\DepositWebhookController;
use App\Http\Controllers\GameEmbedController;
use App\Http\Controllers\ReferralApiController;
use App\Http\Controllers\SpaController;
use App\Services\SiteLayoutData;
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
Route::post('/api/webhooks/deposit', DepositWebhookController::class)->middleware('throttle:deposit-webhook');

Route::get('/csrf-token', static fn () => response()->json(['csrfToken' => csrf_token()]))
    ->middleware('throttle:api-csrf')
    ->name('csrf.token');

Route::get('/api/site-layout', static function () {
    $data = SiteLayoutData::shared();

    return response()->json($data)->header('Cache-Control', 'public, max-age=60');
})->middleware('throttle:api-player-read');

Route::get('/api/home', static function () {
    return response()
        ->json([
            'featuredGames' => SiteLayoutData::featuredHomeGames()->values(),
            'homeMatches' => SiteLayoutData::homeMatchHighlights(),
        ])
        ->header('Cache-Control', 'public, max-age=60');
})->middleware('throttle:api-player-read');

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

Route::prefix('hakai/admin')->name('admin.')->group(function (): void {
    Route::middleware('guest:admin')->group(function (): void {
        Route::get('login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('login', [AdminLoginController::class, 'store'])->middleware('throttle:auth-login')->name('login.store');
    });

    Route::middleware(['auth:admin', 'throttle:admin', \App\Http\Middleware\ClearLayoutCache::class])->group(function (): void {
        Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        // Games
        Route::resource('games', GameAdminController::class)->except(['show']);

        // Game categories
        Route::resource('game-categories', GameCategoryAdminController::class)->except(['show']);

        // Homepage cricket highlights
        Route::resource('home-cricket-matches', HomeCricketMatchAdminController::class)->except(['show']);

        // Navigation
        Route::get('navigation', [NavigationAdminController::class, 'index'])->name('navigation.index');
        Route::get('navigation/create', [NavigationAdminController::class, 'create'])->name('navigation.create');
        Route::post('navigation', [NavigationAdminController::class, 'store'])->name('navigation.store');
        Route::get('navigation/{item}/edit', [NavigationAdminController::class, 'edit'])->name('navigation.edit');
        Route::put('navigation/{item}', [NavigationAdminController::class, 'update'])->name('navigation.update');
        Route::delete('navigation/{item}', [NavigationAdminController::class, 'destroy'])->name('navigation.destroy');

        // Footer
        Route::get('footer', [FooterAdminController::class, 'index'])->name('footer.index');
        Route::get('footer/sections/{section}/items/create', [FooterAdminController::class, 'createItem'])->name('footer.items.create');
        Route::post('footer/sections/{section}/items', [FooterAdminController::class, 'storeItem'])->name('footer.items.store');
        Route::get('footer/items/{footerItem}/edit', [FooterAdminController::class, 'editItem'])->name('footer.items.edit');
        Route::put('footer/items/{footerItem}', [FooterAdminController::class, 'updateItem'])->name('footer.items.update');

        // Banners & media
        Route::resource('media', MediaAssetAdminController::class)->except(['show']);

        // Social links
        Route::resource('social-links', SocialLinkAdminController::class)->except(['show']);

        // Payment methods
        Route::resource('payment-methods', PaymentMethodAdminController::class)->except(['show']);

        // Deposits
        Route::get('deposits', [TransactionAdminController::class, 'deposits'])->name('deposits.index');
        Route::post('deposits/{deposit}/status', [TransactionAdminController::class, 'updateDepositStatus'])->name('deposits.status');

        // Withdrawals
        Route::get('withdrawals', [TransactionAdminController::class, 'withdrawals'])->name('withdrawals.index');
        Route::post('withdrawals/{withdrawal}/status', [TransactionAdminController::class, 'updateWithdrawalStatus'])->name('withdrawals.status');

        // Messages
        Route::get('messages', [MessageAdminController::class, 'index'])->name('messages.index');
        Route::get('messages/create', [MessageAdminController::class, 'create'])->name('messages.create');
        Route::post('messages', [MessageAdminController::class, 'store'])->name('messages.store');
        Route::delete('messages/{message}', [MessageAdminController::class, 'destroy'])->name('messages.destroy');

        // Site settings
        Route::get('settings', [SiteSettingAdminController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SiteSettingAdminController::class, 'update'])->name('settings.update');

        // Players
        Route::get('users', [UserAdminController::class, 'index'])->name('users.index');
        Route::post('users/{user}/role', [UserAdminController::class, 'updateRole'])->name('users.role');
    });
});

Route::middleware('throttle:spa-html')->group(function (): void {
    /** Loaded inside an iframe from the React route `/games/play/{id}` (token bridge + remote game). */
    Route::get('/games/iframe-shell/{id}', [GameEmbedController::class, 'show'])->where('id', '[0-9]+')->name('games.iframe-shell');
});

Route::fallback(SpaController::class)->middleware('throttle:spa-html');
