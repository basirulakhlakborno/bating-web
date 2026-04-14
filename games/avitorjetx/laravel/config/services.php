<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    | Main Babu88 site (player logs in here). Used for redirects when not bridged.
    | bridge_jwt_secret must match the signing key used by App\Support\JwtToken on the main app
    | (JWT_SECRET there, or decoded APP_KEY if JWT_SECRET is unset).
    */
    'root_app' => [
        'url' => rtrim((string) env('ROOT_APP_URL', 'http://localhost'), '/'),
        'login_path' => env('ROOT_APP_LOGIN_PATH', '/login'),
        'bridge_jwt_secret' => (string) env('ROOT_BRIDGE_JWT_SECRET', ''),
    ],

];
