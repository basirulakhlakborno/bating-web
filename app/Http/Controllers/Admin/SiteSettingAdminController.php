<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingAdminController extends Controller
{
    protected array $simpleKeys = [
        'brand_official_url',
        'brand_footer_logo_path',
        'brand_tagline_en',
        'brand_copyright_bn',
        'intercom_app_id',
        'brand_drawer_logo_path',
        'site_html_title',
        'site_meta_description',
        'site_meta_keywords',
        'site_og_image',
        'site_loader_aria_label',
        'home_referral_headline_en',
        'home_referral_body_bn',
        'home_referral_mobile_section_bn',
        'home_referral_mobile_headline_en',
    ];

    public function edit(): View
    {
        $settings = [];
        foreach ([...$this->simpleKeys, 'brand_header_logo_path', 'footer_seo_main', 'footer_seo_expandable'] as $key) {
            $settings[$key] = SiteSetting::getValue($key, '');
        }

        $seoMain = json_decode($settings['footer_seo_main'] ?? '', true);
        $settings['seo_heading'] = $seoMain['heading'] ?? '';
        $settings['seo_intro'] = $seoMain['intro'] ?? '';

        $expandable = json_decode($settings['footer_seo_expandable'] ?? '', true);
        $settings['expandable_section_heading'] = $expandable['section_heading'] ?? '';
        $blocks = [];
        foreach (($expandable['columns'] ?? []) as $col) {
            foreach ((array) $col as $item) {
                $blocks[] = [
                    'heading' => $item['heading'] ?? '',
                    'body' => $item['body'] ?? '',
                ];
            }
        }
        $settings['expandable_blocks'] = $blocks;

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'brand_official_url' => ['nullable', 'string', 'max:512'],
            'brand_footer_logo_path' => ['nullable', 'string', 'max:512'],
            'brand_header_logo_path' => ['nullable', 'string', 'max:512'],
            'brand_tagline_en' => ['nullable', 'string', 'max:512'],
            'brand_copyright_bn' => ['nullable', 'string', 'max:512'],
            'intercom_app_id' => ['nullable', 'string', 'max:64'],
            'brand_drawer_logo_path' => ['nullable', 'string', 'max:512'],
            'site_html_title' => ['nullable', 'string', 'max:512'],
            'site_meta_description' => ['nullable', 'string', 'max:2048'],
            'site_meta_keywords' => ['nullable', 'string', 'max:512'],
            'site_og_image' => ['nullable', 'string', 'max:512'],
            'site_loader_aria_label' => ['nullable', 'string', 'max:255'],
            'home_referral_headline_en' => ['nullable', 'string', 'max:512'],
            'home_referral_body_bn' => ['nullable', 'string', 'max:4096'],
            'home_referral_mobile_section_bn' => ['nullable', 'string', 'max:255'],
            'home_referral_mobile_headline_en' => ['nullable', 'string', 'max:512'],
            'header_logo' => ['nullable', 'file', 'max:8192', 'mimes:jpeg,jpg,png,gif,webp,svg'],
            'remove_header_logo' => ['nullable', 'boolean'],
            'seo_heading' => ['nullable', 'string', 'max:512'],
            'seo_intro' => ['nullable', 'string'],
            'expandable_section_heading' => ['nullable', 'string', 'max:512'],
            'blocks' => ['nullable', 'array'],
            'blocks.*.heading' => ['nullable', 'string', 'max:512'],
            'blocks.*.body' => ['nullable', 'string'],
        ]);

        foreach ($this->simpleKeys as $key) {
            SiteSetting::setValue($key, $data[$key] ?? '');
        }

        $currentHeaderLogo = SiteSetting::getValue('brand_header_logo_path', '');
        if ($request->hasFile('header_logo')) {
            $this->deleteStoredPublicUpload($currentHeaderLogo);
            $stored = $request->file('header_logo')->store('site-header', 'public');
            SiteSetting::setValue('brand_header_logo_path', '/storage/'.$stored);
        } elseif ($request->boolean('remove_header_logo')) {
            $this->deleteStoredPublicUpload($currentHeaderLogo);
            SiteSetting::setValue('brand_header_logo_path', '');
        } else {
            SiteSetting::setValue('brand_header_logo_path', trim((string) ($data['brand_header_logo_path'] ?? '')));
        }

        $seoMain = json_encode([
            'heading' => $data['seo_heading'] ?? '',
            'intro' => $data['seo_intro'] ?? '',
        ], JSON_UNESCAPED_UNICODE);
        SiteSetting::setValue('footer_seo_main', $seoMain);

        $blocks = array_values(array_filter($data['blocks'] ?? [], fn ($b) => trim($b['heading'] ?? '') !== '' || trim($b['body'] ?? '') !== ''));
        $columns = array_chunk($blocks, (int) ceil(max(count($blocks), 1) / 3));
        while (count($columns) < 3) {
            $columns[] = [];
        }
        $expandable = json_encode([
            'section_heading' => $data['expandable_section_heading'] ?? '',
            'columns' => $columns,
        ], JSON_UNESCAPED_UNICODE);
        SiteSetting::setValue('footer_seo_expandable', $expandable);

        return redirect()->route('admin.settings.edit')->with('status', 'Settings saved.');
    }

    private function deleteStoredPublicUpload(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }
        if (! str_starts_with($path, '/storage/')) {
            return;
        }
        $relative = ltrim(substr($path, strlen('/storage/')), '/');
        if ($relative !== '') {
            Storage::disk('public')->delete($relative);
        }
    }
}
