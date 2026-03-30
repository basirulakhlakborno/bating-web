<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingAdminController extends Controller
{
    protected array $keys = [
        'brand_official_url',
        'brand_footer_logo_path',
        'brand_tagline_en',
        'brand_copyright_bn',
        'footer_seo_main',
        'footer_seo_expandable',
    ];

    public function edit(): View
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = SiteSetting::getValue($key, '');
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'brand_official_url' => ['nullable', 'string', 'max:512'],
            'brand_footer_logo_path' => ['nullable', 'string', 'max:512'],
            'brand_tagline_en' => ['nullable', 'string', 'max:512'],
            'brand_copyright_bn' => ['nullable', 'string', 'max:512'],
            'footer_seo_main' => ['nullable', 'string'],
            'footer_seo_expandable' => ['nullable', 'string'],
        ]);

        foreach ($this->keys as $key) {
            SiteSetting::setValue($key, $data[$key] ?? '');
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Settings saved.');
    }
}
