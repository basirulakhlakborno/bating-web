@extends('admin.layout')

@section('pretitle', 'System')
@section('title', 'Site settings')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card mb-4" id="header-settings">
            <div class="card-header">
                <h3 class="card-title">Header</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary">Logo shown in the top bar on desktop and mobile (and on the first-load splash).</p>
                @php
                    $headerPath = old('brand_header_logo_path', $settings['brand_header_logo_path'] ?? '');
                    $headerPreview = $headerPath !== '' ? (str_starts_with($headerPath, 'http') ? $headerPath : asset(ltrim($headerPath, '/'))) : null;
                @endphp
                <div class="mb-3">
                    <label class="form-label">Upload header logo</label>
                    <input type="file" name="header_logo" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    <small class="form-hint">JPEG, PNG, GIF, WebP, or SVG. Max 8&nbsp;MB. Saved under <code>/storage/site-header/</code>.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Or set image URL / path</label>
                    <input type="text" name="brand_header_logo_path" class="form-control" value="{{ $headerPath }}" placeholder="/static/… or https://…">
                    <small class="form-hint">Path on this server (starting with <code>/</code>) or a full URL. Leave empty if you do not want a header logo.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile menu (drawer) logo path</label>
                    <input type="text" name="brand_drawer_logo_path" class="form-control" value="{{ old('brand_drawer_logo_path', $settings['brand_drawer_logo_path'] ?? '') }}" placeholder="/static/…">
                    <small class="form-hint">Shown in the slide-out menu. Same rules as the header logo.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Preview</label>
                    <div class="border rounded p-3 bg-light d-inline-block">
                        @if ($headerPreview)
                            <img src="{{ $headerPreview }}" alt="Header logo preview" style="max-height: 56px; max-width: 320px; object-fit: contain;">
                        @else
                            <span class="text-secondary small">No header logo configured.</span>
                        @endif
                    </div>
                </div>
                <div class="form-check mb-0">
                    <input type="checkbox" class="form-check-input" name="remove_header_logo" id="remove_header_logo" value="1">
                    <label class="form-check-label" for="remove_header_logo">Remove uploaded header file and clear the header logo path</label>
                </div>
            </div>
        </div>

        <div class="card mb-4" id="home-page-settings">
            <div class="card-header">
                <h3 class="card-title">Home page</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary small mb-3">Referral promo block under the homepage matches (desktop banner text + mobile “প্রচার” section).</p>
                <div class="mb-3">
                    <label class="form-label">Desktop headline (English)</label>
                    <input type="text" name="home_referral_headline_en" class="form-control" value="{{ old('home_referral_headline_en', $settings['home_referral_headline_en'] ?? '') }}" maxlength="512">
                </div>
                <div class="mb-3">
                    <label class="form-label">Intro paragraph (Bengali)</label>
                    <textarea name="home_referral_body_bn" class="form-control" rows="4" maxlength="4096">{{ old('home_referral_body_bn', $settings['home_referral_body_bn'] ?? '') }}</textarea>
                    <small class="form-hint">Shown under the headline on desktop and in the mobile promo block. Keep it concise; the site uses a slightly smaller type size.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile section label (Bengali)</label>
                    <input type="text" name="home_referral_mobile_section_bn" class="form-control" value="{{ old('home_referral_mobile_section_bn', $settings['home_referral_mobile_section_bn'] ?? '') }}" maxlength="255" placeholder="প্রচার">
                </div>
                <div class="mb-0">
                    <label class="form-label">Mobile sub-headline (English)</label>
                    <input type="text" name="home_referral_mobile_headline_en" class="form-control" value="{{ old('home_referral_mobile_headline_en', $settings['home_referral_mobile_headline_en'] ?? '') }}" maxlength="512">
                </div>
            </div>
        </div>

        <div class="card mb-4" id="document-seo-settings">
            <div class="card-header">
                <h3 class="card-title">Document &amp; SEO</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary">HTML <code>&lt;title&gt;</code>, meta tags, splash loader accessibility, and social preview image (all stored in the database).</p>
                <div class="mb-3">
                    <label class="form-label">HTML document title</label>
                    <input type="text" name="site_html_title" class="form-control" value="{{ old('site_html_title', $settings['site_html_title'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta description</label>
                    <textarea name="site_meta_description" class="form-control" rows="3">{{ old('site_meta_description', $settings['site_meta_description'] ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta keywords</label>
                    <input type="text" name="site_meta_keywords" class="form-control" value="{{ old('site_meta_keywords', $settings['site_meta_keywords'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Open Graph image path</label>
                    <input type="text" name="site_og_image" class="form-control" value="{{ old('site_og_image', $settings['site_og_image'] ?? '') }}" placeholder="/static/image/logo/logo.webp">
                </div>
                <div class="mb-0">
                    <label class="form-label">Splash loader <code>aria-label</code></label>
                    <input type="text" name="site_loader_aria_label" class="form-control" value="{{ old('site_loader_aria_label', $settings['site_loader_aria_label'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Branding</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary">Footer logo, wording, and legal line.</p>
                <div class="mb-3">
                    <label class="form-label">Public website address</label>
                    <input type="text" name="brand_official_url" class="form-control" value="{{ old('brand_official_url', $settings['brand_official_url'] ?? '') }}" placeholder="https://…">
                </div>
                <div class="mb-3">
                    <label class="form-label">Footer logo file</label>
                    <input type="text" name="brand_footer_logo_path" class="form-control" value="{{ old('brand_footer_logo_path', $settings['brand_footer_logo_path'] ?? '') }}" placeholder="/static/image/footer/logo.png">
                    <small class="form-hint">Path to the logo image on the server.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tagline (English)</label>
                    <input type="text" name="brand_tagline_en" class="form-control" value="{{ old('brand_tagline_en', $settings['brand_tagline_en'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Copyright line (Bengali)</label>
                    <input type="text" name="brand_copyright_bn" class="form-control" value="{{ old('brand_copyright_bn', $settings['brand_copyright_bn'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Integrations</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Intercom App ID</label>
                    <input type="text" name="intercom_app_id" class="form-control" value="{{ old('intercom_app_id', $settings['intercom_app_id'] ?? '') }}" placeholder="e.g. jyk27uux" maxlength="64">
                    <small class="form-hint">The Intercom workspace ID used for live chat support. Leave empty to disable.</small>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Footer story text</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary small mb-3">This appears in the footer below the game lists. A heading and an introduction paragraph.</p>
                <div class="mb-3">
                    <label class="form-label">Heading</label>
                    <input type="text" name="seo_heading" class="form-control" value="{{ old('seo_heading', $settings['seo_heading'] ?? '') }}" placeholder="Main footer heading">
                </div>
                <div class="mb-3">
                    <label class="form-label">Introduction</label>
                    <textarea name="seo_intro" class="form-control" rows="5" placeholder="Write the intro text here…">{{ old('seo_intro', $settings['seo_intro'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Read more sections</h3>
            </div>
            <div class="card-body">
                <p class="text-secondary small mb-3">These appear in the collapsible "Read more" area at the bottom of the footer. Each block has a heading and a paragraph. They are split evenly across 3 columns.</p>
                <div class="mb-4">
                    <label class="form-label">Section heading</label>
                    <input type="text" name="expandable_section_heading" class="form-control" value="{{ old('expandable_section_heading', $settings['expandable_section_heading'] ?? '') }}" placeholder="e.g. যেই গেমগুলো পাবেন">
                </div>

                <div id="seo-blocks">
                    @php $blocks = old('blocks', $settings['expandable_blocks'] ?? []); @endphp
                    @foreach ($blocks as $i => $block)
                        <div class="card card-body mb-3 bg-light seo-block" data-index="{{ $i }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-secondary">Block {{ $i + 1 }}</span>
                                <button type="button" class="btn btn-sm btn-ghost-danger remove-block-btn" title="Remove">
                                    <i class="ti ti-trash-filled"></i>
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Heading</label>
                                <input type="text" name="blocks[{{ $i }}][heading]" class="form-control" value="{{ $block['heading'] ?? '' }}">
                            </div>
                            <div>
                                <label class="form-label">Paragraph</label>
                                <textarea name="blocks[{{ $i }}][body]" class="form-control" rows="3">{{ $block['body'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="add-block-btn">
                    <i class="ti ti-circle-plus-filled me-1"></i>Add block
                </button>
            </div>
        </div>

        <div class="mb-4 text-end">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    const container = document.getElementById('seo-blocks');
    const addBtn = document.getElementById('add-block-btn');
    if (!container || !addBtn) return;

    function nextIndex() {
        let max = -1;
        container.querySelectorAll('.seo-block').forEach(function (el) {
            const idx = parseInt(el.dataset.index, 10);
            if (idx > max) max = idx;
        });
        return max + 1;
    }

    function renumberLabels() {
        container.querySelectorAll('.seo-block').forEach(function (el, i) {
            var label = el.querySelector('.fw-bold.small');
            if (label) label.textContent = 'Block ' + (i + 1);
        });
    }

    addBtn.addEventListener('click', function () {
        var idx = nextIndex();
        var html = '<div class="card card-body mb-3 bg-light seo-block" data-index="' + idx + '">'
            + '<div class="d-flex justify-content-between align-items-center mb-2">'
            + '<span class="fw-bold small text-secondary">Block</span>'
            + '<button type="button" class="btn btn-sm btn-ghost-danger remove-block-btn" title="Remove"><i class="ti ti-trash-filled"></i></button>'
            + '</div>'
            + '<div class="mb-2"><label class="form-label">Heading</label><input type="text" name="blocks[' + idx + '][heading]" class="form-control"></div>'
            + '<div><label class="form-label">Paragraph</label><textarea name="blocks[' + idx + '][body]" class="form-control" rows="3"></textarea></div>'
            + '</div>';
        container.insertAdjacentHTML('beforeend', html);
        renumberLabels();
    });

    container.addEventListener('click', function (e) {
        var btn = e.target.closest('.remove-block-btn');
        if (!btn) return;
        btn.closest('.seo-block').remove();
        renumberLabels();
    });
})();
</script>
@endpush
