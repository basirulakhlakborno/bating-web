<?php

/**
 * HTTP rate limits (Laravel throttle). Tune via .env for production load.
 *
 * Authenticated player APIs use per-user keys (JWT `sub`) when possible so
 * many clients behind one NAT IP do not share one bucket.
 *
 * Multi-server: set CACHE_STORE=redis (or memcached) so counters are shared across app nodes.
 */
return [

    'login_per_minute' => (int) env('RATE_LIMIT_LOGIN_PER_MINUTE', 12),

    'register_per_minute' => (int) env('RATE_LIMIT_REGISTER_PER_MINUTE', 8),

    /** GET /register/captcha — image generation; allow retries without abuse. */
    'captcha_per_minute' => (int) env('RATE_LIMIT_CAPTCHA_PER_MINUTE', 45),

    'csrf_per_minute' => (int) env('RATE_LIMIT_CSRF_PER_MINUTE', 120),

    'logout_per_minute' => (int) env('RATE_LIMIT_LOGOUT_PER_MINUTE', 40),

    /**
     * GET /api/me, /api/inbox, /api/referral, /api/bank/history — polling-heavy.
     */
    'api_read_per_user_minute' => (int) env('RATE_LIMIT_API_READ_USER_MINUTE', 300),
    'api_read_per_ip_minute' => (int) env('RATE_LIMIT_API_READ_IP_MINUTE', 180),

    /** POST /api/profile/password */
    'api_write_per_user_minute' => (int) env('RATE_LIMIT_API_WRITE_USER_MINUTE', 45),
    'api_write_per_ip_minute' => (int) env('RATE_LIMIT_API_WRITE_IP_MINUTE', 24),

    /** POST /api/bank/withdraw */
    'api_withdraw_per_user_minute' => (int) env('RATE_LIMIT_WITHDRAW_USER_MINUTE', 36),
    'api_withdraw_per_ip_minute' => (int) env('RATE_LIMIT_WITHDRAW_IP_MINUTE', 24),

    /** HTML shell routes + SPA fallback (GET). */
    'spa_html_per_minute' => (int) env('RATE_LIMIT_SPA_HTML_PER_MINUTE', 300),

    /** Admin UI (session user id). */
    'admin_per_minute' => (int) env('RATE_LIMIT_ADMIN_PER_MINUTE', 400),

    /** POST /api/webhooks/deposit — gateways may burst. */
    'deposit_webhook_per_minute' => (int) env('RATE_LIMIT_DEPOSIT_WEBHOOK_PER_MINUTE', 600),
];
