<?php

namespace App\Services;

use App\Models\FooterSection;
use App\Models\Game;
use App\Models\HomeCricketMatch;
use App\Models\NavigationItem;
use App\Models\PaymentMethod;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteLayoutData
{
    public static function shared(): array
    {
        return Cache::remember('site_layout_data', 300, static function () {
            return self::buildShared();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('site_layout_data');
    }

    protected static function buildShared(): array
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
            ->where('slug', '!=', 'ambassadors')
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

        $featuredGames = self::featuredHomeGames();

        self::rewriteNavAssetPaths($desktopNav);
        self::rewriteNavAssetPaths($drawer);
        self::rewriteFooterAssetPaths($footerSections);
        self::rewritePaymentAssetPaths($payments);
        self::rewriteSocialAssetPaths($socials);
        self::rewriteGameThumbPaths($featuredGames);

        return [
            'layoutDesktopNav' => $desktopNav,
            'layoutDrawerTop' => $drawer->where('drawer_group', 'top')->values(),
            'layoutDrawerGames' => $drawer->where('drawer_group', 'games')->values(),
            'layoutDrawerOthers' => $drawer->where('drawer_group', 'others')->values(),
            'layoutFooterSections' => $footerSections,
            'layoutPaymentMethods' => $payments,
            'layoutSocialLinks' => $socials,
            'layoutFeaturedGames' => $featuredGames,
            'layoutIframeGamePlayHref' => self::iframeGamePlayHref(),
            'layoutHomeMatches' => self::homeMatchHighlights(),
            'layoutSiteBrandOfficialUrl' => self::strSetting('brand_official_url'),
            'layoutSiteHeaderLogoPath' => self::publicAssetUrl(self::strSetting('brand_header_logo_path')),
            'layoutSiteDrawerLogoPath' => self::publicAssetUrl(self::strSetting('brand_drawer_logo_path')),
            'layoutSiteBrandLogoPath' => self::publicAssetUrl(self::strSetting('brand_footer_logo_path')),
            'layoutSiteBrandTagline' => self::strSetting('brand_tagline_en'),
            'layoutSiteCopyright' => self::strSetting('brand_copyright_bn'),
            'layoutSiteHtmlTitle' => self::strSetting('site_html_title'),
            'layoutSiteMetaDescription' => self::strSetting('site_meta_description'),
            'layoutSiteMetaKeywords' => self::strSetting('site_meta_keywords'),
            'layoutSiteOgImage' => self::publicAssetUrl(self::strSetting('site_og_image')),
            'layoutSiteLoaderAriaLabel' => self::strSetting('site_loader_aria_label'),
            'layoutFooterSeoMain' => self::footerSeoMain(),
            'layoutFooterSeoExpandable' => self::footerSeoExpandable(),
            'intercomAppId' => self::strSetting('intercom_app_id'),
            'layoutHomeReferralHeadlineEn' => self::strSetting('home_referral_headline_en'),
            'layoutHomeReferralBodyBn' => self::strSetting('home_referral_body_bn'),
            'layoutHomeReferralMobileSectionBn' => self::strSetting('home_referral_mobile_section_bn'),
            'layoutHomeReferralMobileHeadlineEn' => self::strSetting('home_referral_mobile_headline_en'),
        ];
    }

    /**
     * First active iframe-embed game: full path for Laravel `/games/play/{id}` shell.
     */
    public static function iframeGamePlayHref(): string
    {
        if (! Schema::hasTable('games') || ! Schema::hasColumn('games', 'opens_in_iframe')) {
            return '';
        }

        $id = Game::query()
            ->where('is_active', true)
            ->where('opens_in_iframe', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->value('id');

        return $id ? '/games/play/'.$id : '';
    }

    /**
     * Active, homepage-featured games (thumbnails rewritten to public URLs).
     *
     * @return \Illuminate\Support\Collection<int, Game>
     */
    public static function featuredHomeGames(): \Illuminate\Support\Collection
    {
        if (! Schema::hasTable('games')) {
            return collect();
        }

        $featuredGames = Game::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('category')
            ->limit(24)
            ->get();

        self::rewriteGameThumbPaths($featuredGames);

        return $featuredGames;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function homeMatchHighlights(): array
    {
        if (! Schema::hasTable('home_cricket_matches')) {
            return [];
        }

        return HomeCricketMatch::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('match_starts_at')
            ->limit(50)
            ->get()
            ->map(fn (HomeCricketMatch $m) => $m->toPlayerCard())
            ->values()
            ->all();
    }

    protected static function strSetting(string $key): string
    {
        return (string) (SiteSetting::getValue($key) ?? '');
    }

    /**
     * Build a browser URL for a path served from /public (e.g. /storage/..., /static/...).
     * Uses Laravel's asset() so subdirectory installs (XAMPP) work when APP_URL / ASSET_URL are set.
     */
    protected static function publicAssetUrl(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    protected static function rewriteNavAssetPaths($items): void
    {
        foreach ($items as $item) {
            if ($item->icon_path) {
                $item->setAttribute('icon_path', self::publicAssetUrl($item->icon_path));
            }
        }
    }

    protected static function rewriteFooterAssetPaths($sections): void
    {
        foreach ($sections as $section) {
            foreach ($section->items as $item) {
                if ($item->image_path) {
                    $item->setAttribute('image_path', self::publicAssetUrl($item->image_path));
                }
            }
        }
    }

    protected static function rewritePaymentAssetPaths($payments): void
    {
        foreach ($payments as $pm) {
            if ($pm->image_path) {
                $pm->setAttribute('image_path', self::publicAssetUrl($pm->image_path));
            }
        }
    }

    protected static function rewriteSocialAssetPaths($socials): void
    {
        foreach ($socials as $s) {
            if ($s->icon_path) {
                $s->setAttribute('icon_path', self::publicAssetUrl($s->icon_path));
            }
        }
    }

    protected static function rewriteGameThumbPaths($games): void
    {
        foreach ($games as $g) {
            if ($g->thumbnail_path) {
                $g->setAttribute('thumbnail_path', self::publicAssetUrl($g->thumbnail_path));
            }
        }
    }

    protected static function footerSeoMain(): array
    {
        $raw = SiteSetting::getValue('footer_seo_main');
        if ($raw === null || $raw === '') {
            return ['heading' => '', 'intro' => ''];
        }
        $d = json_decode($raw, true);
        if (! is_array($d)) {
            return ['heading' => '', 'intro' => ''];
        }

        return [
            'heading' => (string) ($d['heading'] ?? ''),
            'intro' => (string) ($d['intro'] ?? ''),
        ];
    }

    protected static function footerSeoExpandable(): array
    {
        $raw = SiteSetting::getValue('footer_seo_expandable');
        if ($raw === null || $raw === '') {
            return ['section_heading' => '', 'columns' => [[], [], []]];
        }
        $d = json_decode($raw, true);
        if (! is_array($d)) {
            return ['section_heading' => '', 'columns' => [[], [], []]];
        }

        $sectionHeading = (string) ($d['section_heading'] ?? '');
        $columns = [];
        foreach ((array) ($d['columns'] ?? []) as $col) {
            $blocks = [];
            foreach ((array) $col as $item) {
                if (! is_array($item)) {
                    continue;
                }
                $blocks[] = [
                    'heading' => (string) ($item['heading'] ?? ''),
                    'body' => (string) ($item['body'] ?? ''),
                ];
            }
            $columns[] = $blocks;
        }
        while (count($columns) < 3) {
            $columns[] = [];
        }

        return [
            'section_heading' => $sectionHeading,
            'columns' => array_slice($columns, 0, 3),
        ];
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
            'layoutIframeGamePlayHref' => '',
            'layoutHomeMatches' => [],
            'layoutSiteBrandOfficialUrl' => '',
            'layoutSiteHeaderLogoPath' => '',
            'layoutSiteDrawerLogoPath' => '',
            'layoutSiteBrandLogoPath' => '',
            'layoutSiteBrandTagline' => '',
            'layoutSiteCopyright' => '',
            'layoutSiteHtmlTitle' => '',
            'layoutSiteMetaDescription' => '',
            'layoutSiteMetaKeywords' => '',
            'layoutSiteOgImage' => '',
            'layoutSiteLoaderAriaLabel' => '',
            'layoutFooterSeoMain' => ['heading' => '', 'intro' => ''],
            'layoutFooterSeoExpandable' => ['section_heading' => '', 'columns' => [[], [], []]],
            'intercomAppId' => '',
            'layoutHomeReferralHeadlineEn' => '',
            'layoutHomeReferralBodyBn' => '',
            'layoutHomeReferralMobileSectionBn' => '',
            'layoutHomeReferralMobileHeadlineEn' => '',
        ];
    }
}
