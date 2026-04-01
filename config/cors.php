<?php

/**
 * CORS for SPA AJAX (e.g. Vite on :5173 → Laravel on :80).
 * When supports_credentials is true, allowed_origins must be explicit (not *).
 */
$defaultOrigins = 'http://localhost:5173,http://127.0.0.1:5173,http://[::1]:5173,https://gg.eimtbd.com,http://gg.eimtbd.com';

$originsEnv = env('CORS_ALLOWED_ORIGINS', $defaultOrigins);

return [

    'paths' => [
        'api/*',
        'api/login',
        'api/me',
        'api/referral',
        'api/deposit',
        'api/webhooks/deposit',
        'api/me',
        'api/profile/password',
        'api/inbox',
        'api/bank/withdraw',
        'api/bank/history',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
        'register/captcha',
        'csrf-token',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_values(array_filter(array_map('trim', explode(',', $originsEnv)))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
