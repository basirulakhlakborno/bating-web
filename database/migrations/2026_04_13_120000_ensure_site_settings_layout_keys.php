<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill site_settings used by SiteLayoutData / SPA so runtime code has no marketing defaults.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $appName = (string) config('app.name', 'Site');

        $scalars = [
            'brand_official_url' => 'https://babu88official.com',
            'brand_footer_logo_path' => '/static/image/footer/babu88-official.png',
            'brand_header_logo_path' => '/static/svg/bb88_logo_animation2.gif',
            'brand_drawer_logo_path' => '/static/svg/babu88_logo_black.svg',
            'brand_tagline_en' => "Bangladesh's No.1 - The Biggest and Most Trusted",
            'brand_copyright_bn' => 'কপিরাইট © 2026 [ ব্র্যান্ড]। সমস্ত অধিকার সংরক্ষিত',
            'intercom_app_id' => 'jyk27uux',
            'site_html_title' => $appName.' | Premium Cricket Exchange | Online Live Casino Bangladesh',
            'site_meta_description' => 'Register and experience the best Cricket Exchange in Bangladesh with 24/7 Service.',
            'site_meta_keywords' => 'cricket exchange, best cricket exchange, cricket betting',
            'site_og_image' => '/static/image/logo/logo.webp',
            'site_loader_aria_label' => 'Loading',
        ];

        foreach ($scalars as $key => $value) {
            if (! SiteSetting::query()->where('key', $key)->exists()) {
                SiteSetting::query()->create(['key' => $key, 'value' => $value]);
            }
        }
    }
};
