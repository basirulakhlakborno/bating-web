<?php

namespace Database\Seeders;

use App\Models\FooterItem;
use App\Models\FooterSection;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\MediaAsset;
use App\Models\NavigationItem;
use App\Models\PaymentMethod;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteContentSeeder extends Seeder
{
    private const SEED_FLAG_KEY = 'site_content_seeded_v1';

    public function run(): void
    {
        if (SiteSetting::query()->where('key', self::SEED_FLAG_KEY)->where('value', '1')->exists()) {
            return;
        }

        // Legacy DBs seeded before the flag existed: skip if core layout rows are already present.
        if (NavigationItem::query()->exists() && FooterSection::query()->exists()) {
            SiteSetting::query()->updateOrCreate(
                ['key' => self::SEED_FLAG_KEY],
                ['value' => '1']
            );

            return;
        }

        // All-or-nothing: if any step fails, nothing is left half-inserted (avoids duplicate errors on re-seed).
        DB::transaction(function (): void {
            $this->seedSiteSettings();
            $crashPlayHref = $this->seedGameCategoriesAndGames();
            $this->seedNavigationDesktop($crashPlayHref);
            $this->seedNavigationDrawer($crashPlayHref);
            $this->seedFooter();
            $this->seedPaymentsAndSocial();
            $this->seedMediaAssets();

            SiteSetting::query()->updateOrCreate(
                ['key' => self::SEED_FLAG_KEY],
                ['value' => '1']
            );
        });
    }

    protected function seedSiteSettings(): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_official_url'],
            ['value' => 'https://babu88official.com']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_footer_logo_path'],
            ['value' => '/static/image/footer/babu88-official.png']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_tagline_en'],
            ['value' => "Bangladesh's No.1 - The Biggest and Most Trusted"]
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_copyright_bn'],
            ['value' => 'কপিরাইট © 2026 [ ব্র্যান্ড]। সমস্ত অধিকার সংরক্ষিত']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'intercom_app_id'],
            ['value' => 'jyk27uux']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_header_logo_path'],
            ['value' => '/static/svg/bb88_logo_animation2.gif']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'brand_drawer_logo_path'],
            ['value' => '/static/svg/babu88_logo_black.svg']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_html_title'],
            ['value' => config('app.name', 'Babu88').' | Premium Cricket Exchange | Online Live Casino Bangladesh']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_meta_description'],
            ['value' => 'Register and experience the best Cricket Exchange in Bangladesh with 24/7 Service.']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_meta_keywords'],
            ['value' => 'cricket exchange, best cricket exchange, cricket betting']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_og_image'],
            ['value' => '/static/image/logo/logo.webp']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_loader_aria_label'],
            ['value' => 'Loading']
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_referral_headline_en'],
            ['value' => 'Refer friends and start earning']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_referral_body_bn'],
            ['value' => base64_decode('4Kas4Ka+4KaC4Kay4Ka+4Kam4KeH4Ka24KeH4KawIOCmqOCmgiDgp6cg4Kar4KeN4Kaw4KeH4Kao4KeN4KahIOCmsOCnh+Cmq+CmvuCmsOCnh+CmsiDgpqrgp43gprDgp4vgppfgp43gprDgpr7gpq4g4KaP4KaW4KaoIOCmj+CmluCmvuCmqOCnhyEg4KaP4KaV4Kac4KaoIOCmrOCmqOCnjeCmp+CngeCmleCnhyDgprDgp4fgpqvgpr7gprAg4KaV4Kaw4Kay4KeHIOCmq+CnjeCmsOCmvyDgp7Pgp6vgp6bgp6Yg4KaJ4Kaq4Ka+4Kaw4KeN4Kac4KaoIOCmleCmsOCngeCmqCDgpo/gpqzgpoIg4KaG4Kaq4Kao4Ka+4KawIOCmrOCmqOCnjeCmp+CngSDgpqrgp43gprDgpqTgpr/gpqzgpr7gprAg4Kac4Kau4Ka+IOCmpuCmv+CmsuCnhyDgpobgppzgp4Dgpqzgpqgg4Ka44Kaw4KeN4Kas4KeL4Kaa4KeN4KaaIOCnqCUg4KaV4Kau4Ka/4Ka24KaoIOCmquCmvuCmqCE=', true)]
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_referral_mobile_section_bn'],
            ['value' => 'প্রচার']
        );
        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_referral_mobile_headline_en'],
            ['value' => 'Refer and earn with BABU88']
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'footer_seo_main'],
            ['value' => json_encode([
                'heading' => 'বাংলাদেশের বিশ্বস্ত অনলাইন ক্যাসিনো এবং ক্রিকেট এক্সচেঞ্জ',
                'intro' => 'Babu88 হল বাংলাদেশের প্রধান অনলাইন ক্যাসিনো, মোবাইল এবং ডেস্কটপ ব্যবহারকারীদের জন্য বিভিন্ন ধরনের গেম অফার করে। খেলোয়াড়রা অনলাইনে আসল টাকা জেতার সুযোগ সহ রুলেট, পোকার, ব্যাকার্যাট, ব্ল্যাকজ্যাক এবং এমনকি ক্রিকেট এক্সচেঞ্জ বাজির বিকল্পগুলি উপভোগ করতে পারে। আমাদের প্ল্যাটফর্ম খেলোয়াড়দের জন্য দ্রুত, বিরামহীন গেমপ্লে এবং দুর্দান্ত বোনাস প্রদান করে। আমরা আপনার তথ্য রক্ষা করতে উন্নত এনক্রিপশন প্রযুক্তি ব্যবহার করে নিরাপত্তা এবং নিরাপত্তাকে অগ্রাধিকার দিই, এবং আমাদের গ্রাহক পরিষেবা 24/7 উপলব্ধ। বাংলাদেশের সেরা অনলাইন ক্যাসিনো গেমিং এবং ক্রিকেট এক্সচেঞ্জ বেটিং অভিজ্ঞতার জন্য আজই Babu88-এ যোগ দিন।',
            ], JSON_UNESCAPED_UNICODE)]
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'footer_seo_expandable'],
            ['value' => json_encode([
                'section_heading' => 'যেই গেমগুলো পাবেন',
                'columns' => [
                    [
                        ['heading' => 'স্লট গেম', 'body' => 'BABU88 অনলাইন স্লট গেমগুলি একটি বড় ড্র। প্লেয়াররা ভিডিও স্লট, ঐতিহ্যবাহী স্লট এবং প্রগতিশীল জ্যাকপট স্লটগুলির একটি আকর্ষণীয় বৈচিত্র্য উপভোগ করতে পারে। জিআইএলআই গেমস এবং প্রাগম্যাটিক প্লে-এর মতো শীর্ষ প্রদানকারীর কাছ থেকে মানি কামিং, সুপার অ্যাস এবং আরও অনেক কিছুর মতো ভক্তদের পছন্দ খুঁজুন।'],
                        ['heading' => 'স্পোর্টস ব্যাটিং', 'body' => 'ক্রীড়া উত্সাহীদের জন্য, BABU88 একটি ব্যাপক অনলাইন স্পোর্টস বেটিং প্ল্যাটফর্ম প্রদান করে। খেলোয়াড়রা ফুটবল, বাস্কেটবল, টেনিস, ক্রিকেট এবং আরও অনেক কিছু সহ বিশ্বের বিভিন্ন ক্রীড়া ইভেন্টে বাজি রাখতে পারে। ক্রীড়া বেটিং বিভাগটি প্রতিযোগিতামূলক প্রতিকূলতা এবং একটি ব্যবহারকারী-বান্ধব ইন্টারফেস, যা খেলোয়াড়দের সুবিধামত তাদের বাজি রাখতে এবং তাদের প্রিয় দল এবং ম্যাচগুলিকে রিয়েল টাইমে ট্র্যাক করতে দেয়। ICC, IPL, T20, BPL, LPL, CPL এবং আরও অনেক বড় টুর্নামেন্টে বাজি ধরতে আমাদের ক্রিকেট এক্সচেঞ্জ ব্যবহার করুন!'],
                        ['heading' => 'লাইভ ক্যাসিনো গেম', 'body' => 'অনলাইন ক্যাসিনো বাংলাদেশ BABU88 আপনাকে গেমের সবচেয়ে বড় স্যুট প্রদান করে যেগুলিতে আকর্ষণীয় গেমপ্লে এবং জেতার পরে দুর্দান্ত পুরস্কার রয়েছে। ইভোলিউশন গেমিং (ইভো গেমিং), সুপার স্পেড গেমিং, প্রাগম্যাটিক প্লে এবং এই ক্যাসিনোর মতো জনপ্রিয় বিকাশকারীরা BABU88-এ উপযোগী।'],
                    ],
                    [
                        ['heading' => 'BABU88 এ অর্থপ্রদানের বিকল্প', 'body' => 'সেরা অনলাইন ক্যাসিনো সাইটগুলি অর্থ জমা এবং উত্তোলনের বিভিন্ন উপায় অফার করে। আমরা আমাদের গ্রাহকদের জন্য বিভিন্ন ধরণের অর্থপ্রদানের বিকল্প প্রদান করি, যার মধ্যে নগদ, বিকাশ, স্থানীয় ব্যাঙ্ক স্থানান্তর এবং আরও অনেক কিছুর মতো পেমেন্ট চ্যানেল সহ ই-ওয়ালেট।'],
                        ['heading' => 'লাইসেন্স এবং নিরাপত্তা নীতি', 'body' => 'BABU88 একটি নিরাপদ এবং ন্যায্য গেমিং পরিবেশ বজায় রাখার জন্য কঠোর নীতি এবং প্রবিধান অনুযায়ী কাজ করে। আমরা আমাদের গেমারদের গোপনীয়তা এবং ব্যক্তিগত তথ্য সুরক্ষিত করার জন্য শক্তিশালী নিরাপত্তা ব্যবস্থা রেখেছি। BABU88 দায়িত্বশীল জুয়া খেলার জন্য প্রতিশ্রুতিবদ্ধ এবং আমাদের ব্যবহারকারীদের মধ্যে স্বাস্থ্যকর গেমিং অভ্যাস উন্নীত করার জন্য সরঞ্জাম এবং সংস্থান সরবরাহ করে।'],
                    ],
                    [
                        ['heading' => 'শর্তাবলী', 'body' => 'BABU88 নিয়ম ও শর্তাবলী (T&C) পরিষ্কার এবং সহজবোধ্য, আমাদের প্ল্যাটফর্মের ব্যবহার নিয়ন্ত্রণ করে এমন নিয়ম ও প্রবিধানের রূপরেখা। এই T&Cগুলি অ্যাকাউন্ট পরিচালনা, প্রচার, আমানত, উত্তোলন এবং ব্যাটিং সহ বিভিন্ন দিক কভার করে। একটি মনোরম এবং সঙ্গতিপূর্ণ গেমিং অভিজ্ঞতার নিশ্চয়তা দিতে, খেলোয়াড়দের T&C এর সাথে পরিচিত হওয়া উচিত।'],
                        ['heading' => '24/7 গ্রাহক সহায়তা', 'body' => 'BABU88 সার্বক্ষণিক সহায়তার গুরুত্ব বোঝে, এবং তাই, আমাদের গ্রাহক সহায়তা দিনে 24 ঘন্টা, সপ্তাহের 7 দিন উপলব্ধ। নিবন্ধন, সাইন আপ, জমা বা উত্তোলনের জন্য আপনার সাহায্যের প্রয়োজন হোক না কেন, BABU88 গ্রাহক সহায়তা আপনাকে সেবা দিতে প্রস্তুত।'],
                    ],
                ],
            ], JSON_UNESCAPED_UNICODE)]
        );
    }

    protected function seedNavigationDesktop(?string $crashPlayHref = null): void
    {
        $crashHref = $crashPlayHref ?? '/crash';
        $rows = [
            ['স্লট গেম', '/slot', 1, 'menu-navigator px-1', 'dot', true, true, false],
            ['ক্যাসিনো', '/casino', 2, 'menu-navigator px-1', 'dot', true, true, false],
            ['ক্র্যাশ', $crashHref, 3, 'menu-navigator px-1', 'dot', true, true, false],
            ['ক্রিকেট', '/cricket', 4, 'menu-navigator px-1', 'dot', true, true, false],
            ['টেবিল গেম', '/tablegames', 5, 'menu-navigator px-1', 'dot', true, true, false],
            ['ফাস্ট', '/fastgames', 6, 'menu-navigator px-1', 'dot', true, true, false],
            ['মাছ ধরা', '/fishing', 7, 'menu-navigator px-1', 'dot', true, true, false],
            ['খেলার বই', '/sportsbook', 8, 'menu-navigator px-1', 'dot', true, true, false],
            ['প্রমোশন', '/promotion', 9, 'px-2', 'dot', false, true, false],
            ['বেটিং পাস', '/vip/vipProfile', 10, 'px-2', 'hot', true, true, false],
            ['সুপারিশ', '/referralPreview', 11, 'px-2', 'hot', true, true, false],
            ['VIP', '/viptiers/vip-tier', 12, 'px-2', 'dot', true, true, false],
            ['IPL 2026 বেটিং পাস', '/vipEvent/IPL2026', 13, 'px-2', 'hot', true, true, false],
            ['অ্যাফিলিয়েট', 'https://bit.ly/4hra4xX', 14, 'px-2', 'dot', false, true, true],
            ['পুরস্কার', '/reward/rewardStore', 15, 'px-2', 'dot', true, true, false],
        ];

        foreach ($rows as $r) {
            NavigationItem::query()->create([
                'placement' => 'desktop_nav',
                'label_bn' => $r[0],
                'href' => $r[1],
                'sort_order' => $r[2],
                'label_class' => $r[3],
                'badge_variant' => $r[4],
                'has_badge_ui' => $r[5],
                'show_underline' => $r[6],
                'is_external' => $r[7],
            ]);
        }
    }

    protected function seedNavigationDrawer(?string $crashPlayHref = null): void
    {
        $crashHref = $crashPlayHref ?? '/crash';
        $top = [
            ['প্রমোশন', '/promotion', 1, '/static/svg/mobileMenu/icon_promotion.svg', 'top', [], false],
            ['পুরস্কার', '/reward/rewardStore', 2, '/static/svg/mobileMenu/icon_rewards.svg', 'top', ['badge' => 'নতুন', 'badge_bg' => 'rgb(4, 178, 43)'], false],
            ['রেফারেল প্রোগ্রাম', '/referral/summary', 3, '/static/svg/mobileMenu/icon_referral.svg', 'top', ['variant' => 'referral'], false],
            ['বেটিং পাস', '/vip/vipProfile', 4, '/static/svg/mobileMenu/icon_bettingpass.svg', 'top', ['variant' => 'row_badge_hot'], false],
            ['IPL 2026 বেটিং পাস', '/vipEvent/IPL2026', 5, '/static/svg/mobileMenu/IPL_svg.svg', 'top', ['variant' => 'row_badge_hot'], false],
            ['অ্যাফিলিয়েট', 'https://bit.ly/4hra4xX', 6, '/static/svg/mobileMenu/icon_agents.svg', 'top', [], true],
            ['বেটিং পাস', '/viptiers/vip-tier', 7, '/static/svg/mobileMenu/icon_VIP.svg', 'top', ['variant' => 'row_badge_empty'], false],
        ];

        $games = [
            ['স্লট গেম', '/slot/jili', 1, '/static/svg/mobileMenu/icon_rng.svg', 'games', [], false],
            ['ক্যাসিনো', '/casino', 2, '/static/svg/mobileMenu/icon_ld.svg', 'games', [], false],
            ['ক্র্যাশ', $crashHref, 3, '/static/svg/mobileMenu/icon_crash.svg', 'games', [], false],
            ['ক্রিকেট', '/cricket', 4, '/static/svg/mobileMenu/icon_cricket.svg', 'games', [], false],
            ['টেবিল গেম', '/tablegames', 5, '/static/svg/mobileMenu/icon_table.svg', 'games', [], false],
            ['ফাস্ট', '/fastgames', 6, '/static/svg/mobileMenu/icon_fastgames.svg', 'games', ['badge' => 'নতুন'], false],
            ['মাছ ধরা', '/fishing', 7, '/static/svg/mobileMenu/icon_fishing.svg', 'games', [], false],
            ['খেলার বই', '/sportsbook', 8, '/static/svg/mobileMenu/icon_sb.svg', 'games', [], false],
        ];

        $others = [
            ['প্রায়শই জিজ্ঞাসিত প্রশ্নাবল', '/info/faq', 1, '/static/svg/mobileMenu/icon_FAQ.svg', 'others', ['icon_wrap' => 'button'], false],
        ];

        foreach (array_merge($top, $games, $others) as $r) {
            NavigationItem::query()->create([
                'placement' => 'drawer',
                'label_bn' => $r[0],
                'href' => $r[1],
                'sort_order' => $r[2],
                'icon_path' => $r[3],
                'drawer_group' => $r[4],
                'drawer_meta' => $r[5],
                'is_external' => $r[6],
            ]);
        }
    }

    protected function seedFooter(): void
    {
        $amb = FooterSection::query()->create([
            'slug' => 'ambassadors',
            'title_bn' => 'ব্র্যান্ড অ্যাম্বাসেডর',
            'sort_order' => 1,
        ]);
        foreach ([
            ['Samira Mahi Khan', '2024/2025', '/static/image/footer/samira_mahi_khan.png', 1],
            ['Apu Biswas', '2023/2024', '/static/image/footer/apu_biswas.png', 2],
        ] as $i => $row) {
            FooterItem::query()->create([
                'footer_section_id' => $amb->id,
                'title' => $row[0],
                'subtitle' => $row[1],
                'image_path' => $row[2],
                'sort_order' => $row[3],
            ]);
        }

        $sp = FooterSection::query()->create([
            'slug' => 'sponsorships',
            'title_bn' => 'স্পনসরশিপ',
            'sort_order' => 2,
        ]);
        $sponsors = [
            ['Vegas Vikings', '2025/2026', 'vegas_vikings.png'],
            ['Sudurpaschim Royals', '2024/2025', 'sudurpaschim_royals.png'],
            ['Telugu Warriors', '2024/2025', 'telugu_warriors.png'],
            ['Colombo Strikers', '2024/2025', 'colombo_strikers.png'],
            ['Grand Cayman Jaguars', '2024/2025', 'grand_cayman_jaguars.png'],
            ['Montreal Tigers', '2023/2024', 'montreal_tigers.png'],
            ['Dambulla Aura', '2023/2024', 'dambulla_aurea.png'],
            ['Northern Warriors', '2023/2024', 'northern_warriors.png'],
        ];
        $n = 1;
        foreach ($sponsors as $s) {
            FooterItem::query()->create([
                'footer_section_id' => $sp->id,
                'title' => $s[0],
                'subtitle' => $s[1],
                'image_path' => '/static/image/footer/'.$s[2],
                'sort_order' => $n++,
            ]);
        }
    }

    protected function seedPaymentsAndSocial(): void
    {
        $payments = [
            ['bkash', '/static/image/footer/icon_footer_bkash_colour.svg', 1],
            ['nagad', '/static/image/footer/icon_footer_nagad_colour.svg', 2],
            ['rocket', '/static/image/footer/icon_footer_rocket_colour.svg', 3],
            ['upay', '/static/image/footer/icon_footer_upay_colour.svg', 4],
        ];
        foreach ($payments as $p) {
            PaymentMethod::query()->create([
                'name' => $p[0],
                'image_path' => $p[1],
                'sort_order' => $p[2],
            ]);
        }

        $socials = [
            ['Facebook', '/static/svg/hover_btm-fb.svg', 'https://www.facebook.com/babu88official/', 1],
            ['YouTube', '/static/svg/btm-yt.svg', 'https://www.youtube.com/@BB88SPORTS', 2],
            ['Instagram', '/static/svg/hover_btm-ig.svg', 'https://www.instagram.com/babu88official/', 3],
            ['X', '/static/svg/btm-twitter.svg', 'https://x.com/Babu88Official', 4],
            ['Telegram', '/static/svg/hover_btm-tlg.svg', 'https://t.me/babu88official_bd', 5],
        ];
        foreach ($socials as $s) {
            SocialLink::query()->create([
                'label' => $s[0],
                'icon_path' => $s[1],
                'url' => $s[2],
                'sort_order' => $s[3],
            ]);
        }
    }

    /**
     * @return string|null Href for crash nav (e.g. /games/play/2) when iframe embed game is created
     */
    protected function seedGameCategoriesAndGames(): ?string
    {
        $categories = [
            ['slot', 'স্লট গেম', 'Slots', 1],
            ['crash', 'ক্র্যাশ', 'Crash', 2],
        ];

        $catModels = [];
        foreach ($categories as $c) {
            $catModels[$c[0]] = GameCategory::query()->create([
                'slug' => $c[0],
                'name_bn' => $c[1],
                'name_en' => $c[2],
                'sort_order' => $c[3],
            ]);
        }

        $embedBase = rtrim((string) config('services.aviator.public_url', ''), '/');
        $iframeGame = Game::query()->create([
            'game_category_id' => $catModels['crash']->id,
            'title' => 'Aviator',
            'slug' => 'aviator',
            'provider' => null,
            'thumbnail_path' => '/static/image/logo/logo.webp',
            'href' => '/games/play/0',
            'opens_in_iframe' => true,
            'iframe_remote_base' => $embedBase !== '' ? $embedBase : null,
            'iframe_bridge_path' => 'game-bridge',
            'sort_order' => 0,
            'is_featured' => true,
            'is_active' => true,
        ]);
        $iframeGame->update(['href' => '/games/play/'.$iframeGame->id]);

        $games = [
            ['slot', 'Fortune Gems', 'fortune-gems', 'JILI', '/static/image/logo/logo.webp', '/slot', 1, true],
        ];

        foreach ($games as $g) {
            Game::query()->create([
                'game_category_id' => $catModels[$g[0]]->id,
                'title' => $g[1],
                'slug' => $g[2],
                'provider' => $g[3],
                'thumbnail_path' => $g[4],
                'href' => $g[5],
                'sort_order' => $g[6],
                'is_featured' => $g[7],
                'is_active' => true,
            ]);
        }

        return '/games/play/'.$iframeGame->id;
    }

    protected function seedMediaAssets(): void
    {
        $rows = [
            ['brand-logo-main', '/static/image/logo/logo.webp', 'Babu88 logo', 'brand', 1],
            ['brand-footer-official', '/static/image/footer/babu88-official.png', 'Official site badge', 'brand', 2],
            ['register-banner-bd', '/static/image/banner/registerBanner/register_banner_bd.jpg', 'Register banner', 'header', 3],
            ['ambassador-samira', '/static/image/footer/samira_mahi_khan.png', 'Samira Mahi Khan', 'footer', 4],
            ['ambassador-apu', '/static/image/footer/apu_biswas.png', 'Apu Biswas', 'footer', 5],
            ['payment-bkash', '/static/image/footer/icon_footer_bkash_colour.svg', 'bKash', 'footer', 10],
            ['payment-nagad', '/static/image/footer/icon_footer_nagad_colour.svg', 'Nagad', 'footer', 11],
        ];

        foreach ($rows as $r) {
            MediaAsset::query()->updateOrCreate(
                ['slug' => $r[0]],
                [
                    'path' => $r[1],
                    'alt' => $r[2],
                    'category' => $r[3],
                    'sort_order' => $r[4],
                ]
            );
        }
    }
}
