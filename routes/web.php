<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home', ['title' => config('app.name')]);

Route::view('/login', 'login', [
    'title' => 'লগইন | ' . config('app.name'),
    'metaTitle' => 'লগইন | ' . config('app.name'),
    'ogTitle' => 'লগইন | ' . config('app.name'),
]);

Route::view('/register', 'register', [
    'title' => 'নিবন্ধন | ' . config('app.name'),
    'metaTitle' => 'নিবন্ধন | ' . config('app.name'),
    'ogTitle' => 'নিবন্ধন | ' . config('app.name'),
]);
