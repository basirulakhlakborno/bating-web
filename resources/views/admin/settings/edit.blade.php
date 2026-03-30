@extends('admin.layout')

@section('title', 'Site settings')

@section('content')
    <h1>Site settings</h1>
    <form action="{{ route('admin.settings.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="stack">
            <label>Official site URL</label>
            <input type="text" name="brand_official_url" value="{{ old('brand_official_url', $settings['brand_official_url'] ?? '') }}">
        </div>
        <div class="stack">
            <label>Footer logo path</label>
            <input type="text" name="brand_footer_logo_path" value="{{ old('brand_footer_logo_path', $settings['brand_footer_logo_path'] ?? '') }}">
        </div>
        <div class="stack">
            <label>Brand tagline (English)</label>
            <input type="text" name="brand_tagline_en" value="{{ old('brand_tagline_en', $settings['brand_tagline_en'] ?? '') }}">
        </div>
        <div class="stack">
            <label>Copyright line (Bengali)</label>
            <input type="text" name="brand_copyright_bn" value="{{ old('brand_copyright_bn', $settings['brand_copyright_bn'] ?? '') }}">
        </div>
        <div class="stack">
            <label><code>footer_seo_main</code> (JSON: heading, intro)</label>
            <textarea name="footer_seo_main" rows="8">{{ old('footer_seo_main', $settings['footer_seo_main'] ?? '') }}</textarea>
        </div>
        <div class="stack">
            <label><code>footer_seo_expandable</code> (JSON: section_heading, columns[][])</label>
            <textarea name="footer_seo_expandable" rows="16">{{ old('footer_seo_expandable', $settings['footer_seo_expandable'] ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn">Save</button>
    </form>
@endsection
