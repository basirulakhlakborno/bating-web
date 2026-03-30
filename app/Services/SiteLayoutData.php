<?php

namespace App\Services;

use App\Models\FooterSection;
use App\Models\Game;
use App\Models\NavigationItem;
use App\Models\PaymentMethod;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Schema;

class SiteLayoutData
{
    public static function shared(): array
    {
        if (! Schema::hasTable('navigation_items')) {
            return self::emptyPayload();
        }

        $desktopNav = NavigationItem::query()
            ->where('placement', 'desktop_nav')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $drawer = NavigationItem::query()
            ->where('placement', 'drawer')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $footerSections = FooterSection::query()
            ->with(['items' => fn ($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $payments = PaymentMethod::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $socials = SocialLink::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredGames = Game::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('category')
            ->limit(24)
            ->get();

        $footerSeoMain = self::jsonSetting('footer_seo_main', [
            'heading' => 'বাংলাদেশের বিশ্বস্ত অনলাইন ক্যাসিনো এবং ক্রিকেট এক্সচেঞ্জ',
            'intro' => '',
        ]);

        $footerSeoExpandable = self::jsonSetting('footer_seo_expandable', [
            'section_heading' => 'যেই গেমগুলো পাবেন',
            'columns' => [[], [], []],
        ]);

        return [
            'layoutDesktopNav' => $desktopNav,
            'layoutDrawerTop' => $drawer->where('drawer_group', 'top')->values(),
            'layoutDrawerGames' => $drawer->where('drawer_group', 'games')->values(),
            'layoutDrawerOthers' => $drawer->where('drawer_group', 'others')->values(),
            'layoutFooterSections' => $footerSections,
            'layoutPaymentMethods' => $payments,
            'layoutSocialLinks' => $socials,
            'layoutFeaturedGames' => $featuredGames,
            'layoutSiteBrandOfficialUrl' => SiteSetting::getValue('brand_official_url', 'https://babu88official.com'),
            'layoutSiteBrandLogoPath' => SiteSetting::getValue('brand_footer_logo_path', '/static/image/footer/babu88-official.png'),
            'layoutSiteBrandTagline' => SiteSetting::getValue('brand_tagline_en', "Bangladesh's No.1 - The Biggest and Most Trusted"),
            'layoutSiteCopyright' => SiteSetting::getValue('brand_copyright_bn', 'কপিরাইট © 2026 [ ব্র্যান্ড]। সমস্ত অধিকার সংরক্ষিত'),
            'layoutFooterSeoMain' => $footerSeoMain,
            'layoutFooterSeoExpandable' => $footerSeoExpandable,
        ];
    }

    protected static function jsonSetting(string $key, mixed $default): mixed
    {
        $raw = SiteSetting::getValue($key);
        if ($raw === null || $raw === '') {
            return $default;
        }
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : $default;
    }

    protected static function emptyPayload(): array
    {
        return [
            'layoutDesktopNav' => collect(),
            'layoutDrawerTop' => collect(),
            'layoutDrawerGames' => collect(),
            'layoutDrawerOthers' => collect(),
            'layoutFooterSections' => collect(),
            'layoutPaymentMethods' => collect(),
            'layoutSocialLinks' => collect(),
            'layoutFeaturedGames' => collect(),
            'layoutSiteBrandOfficialUrl' => 'https://babu88official.com',
            'layoutSiteBrandLogoPath' => '/static/image/footer/babu88-official.png',
            'layoutSiteBrandTagline' => "Bangladesh's No.1 - The Biggest and Most Trusted",
            'layoutSiteCopyright' => 'কপিরাইট © 2026 [ ব্র্যান্ড]। সমস্ত অধিকার সংরক্ষিত',
            'layoutFooterSeoMain' => [
                'heading' => 'বাংলাদেশের বিশ্বস্ত অনলাইন ক্যাসিনো এবং ক্রিকেট এক্সচেঞ্জ',
                'intro' => '',
            ],
            'layoutFooterSeoExpandable' => [
                'section_heading' => 'যেই গেমগুলো পাবেন',
                'columns' => [[], [], []],
            ],
        ];
    }
}
