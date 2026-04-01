<?php

/**
 * Referral programme copy and tier ladder (5 rows: direct + 4 depth tiers).
 */
return [
    /** Banner / expansion panel heading (same as production label). */
    'title_bn' => 'রেফারেল প্রোগ্রাম',

    /**
     * Long programme copy — edit here only; SPA reads via GET /api/referral → meta.description_bn.
     */
    'description_bn' =>
        'সেরা সুপারিশ কার্যক্রম এখানে! আপনি এখন প্রতিবার 2% পর্যন্ত আজীবন কমিশন উপার্জন করতে পারেন যখন আপনার দ্বারা সুপারিশ করা আপনার বন্ধু একটি আমানত জমা করে! তার উপরে, আমরা আপনাকে এবং আপনার বন্ধুকে অতিরিক্ত ৳ ৫০০ দিচ্ছি যখন আপনার দ্বারা সুপারিশ করা আপনার প্রতিটি বন্ধু মোট ৳ ২০০০ আমানত জমা করে।',

    /**
     * Business rules (backend): each confirmed deposit pays uplines by tier_definitions rates.
     * When a referred member’s cumulative confirmed deposits (BDT) reach the threshold,
     * referrer + referee each receive the one-time bonus (BDT).
     */
    'deposit_threshold_for_bonus' => env('REFERRAL_DEPOSIT_THRESHOLD', 2000),
    'bonus_currency' => 'BDT',
    'bonus_to_referrer' => env('REFERRAL_BONUS_REFERRER', 500),
    'bonus_to_referee' => env('REFERRAL_BONUS_REFEREE', 500),

    /** Display ladder; `direct` row label is replaced with the member’s permanent referral code. */
    'tier_definitions' => [
        ['slug' => 'direct', 'label' => '', 'rate_percent' => 2.0],
        ['slug' => 'tier_1', 'label' => 'Tier 1 (1.5%)', 'rate_percent' => 1.5],
        ['slug' => 'tier_2', 'label' => 'Tier 2 (1%)', 'rate_percent' => 1.0],
        ['slug' => 'tier_3', 'label' => 'Tier 3 (0.5%)', 'rate_percent' => 0.5],
        ['slug' => 'tier_4', 'label' => 'Tier 4 (0.25%)', 'rate_percent' => 0.25],
    ],

    'report_days' => 30,

    'history_limit' => 50,

    /**
     * Deposits: wallet credit + referral processing.
     * Production: disable JWT (players must not self-fund); use webhook from payment gateway.
     */
    'deposit' => [
        /** Allow POST /api/deposit with JWT (dev / sandbox only). */
        'jwt_enabled' => filter_var(env('DEPOSIT_JWT_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
        /** Accept POST /api/webhooks/deposit with HMAC signature. */
        'webhook_enabled' => filter_var(env('DEPOSIT_WEBHOOK_ENABLED', true), FILTER_VALIDATE_BOOLEAN),
        'webhook_secret' => env('DEPOSIT_WEBHOOK_SECRET'),
        'max_amount' => (float) env('DEPOSIT_MAX_AMOUNT', 10000000),
        'throttle_per_minute' => (int) env('DEPOSIT_THROTTLE_PER_MINUTE', 30),
    ],
];
