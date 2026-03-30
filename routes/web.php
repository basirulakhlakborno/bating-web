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
use Illuminate\Support\Facades\Route;

Route::view('/', 'home', ['title' => config('app.name')]);

foreach (config('nav_pages') as $path => $row) {
    $label = $row['title'] ?? $path;
    $suffix = ' | ' . config('app.name');
    Route::view($path, 'nav-page', [
        'title' => $label . $suffix,
        'metaTitle' => $label . $suffix,
        'ogTitle' => $label . $suffix,
        'heading' => $row['heading'] ?? $label,
        'description' => $row['description'] ?? null,
    ]);
}

Route::view('/login', 'login', [
    'title' => 'লগইন | ' . config('app.name'),
    'metaTitle' => 'লগইন | ' . config('app.name'),
    'ogTitle' => 'লগইন | ' . config('app.name'),
])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::view('/register', 'register', [
    'title' => 'নিবন্ধন | ' . config('app.name'),
    'metaTitle' => 'নিবন্ধন | ' . config('app.name'),
    'ogTitle' => 'নিবন্ধন | ' . config('app.name'),
])->name('register');

Route::get('/register/captcha', [RegisterCaptchaController::class, 'image'])->name('register.captcha');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::view('/profileAccount', 'nav-page', [
    'title' => 'অ্যাকাউন্ট | '.config('app.name'),
    'metaTitle' => 'অ্যাকাউন্ট | '.config('app.name'),
    'ogTitle' => 'অ্যাকাউন্ট | '.config('app.name'),
    'heading' => 'অ্যাকাউন্ট',
    'description' => 'প্রোফাইল এবং সেটিংস শীঘ্রই এখানে থাকবে।',
])->middleware('auth');

Route::view('/profile/inbox', 'nav-page', [
    'title' => 'ইনবক্স | '.config('app.name'),
    'metaTitle' => 'ইনবক্স | '.config('app.name'),
    'ogTitle' => 'ইনবক্স | '.config('app.name'),
    'heading' => 'ইনবক্স',
    'description' => 'আপনার বার্তা এখানে দেখানো হবে।',
])->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
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
