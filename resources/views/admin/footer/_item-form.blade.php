@php
    $fi = $footerItem;
    $imgPath = old('image_path', $fi?->image_path);
    $previewUrl = '';
    if ($imgPath) {
        $previewUrl = str_starts_with($imgPath, 'http') ? $imgPath : asset(ltrim($imgPath, '/'));
    }
@endphp

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $fi?->title) }}" required maxlength="255" placeholder="e.g. Samira Mahi Khan">
</div>
<div class="mb-3">
    <label class="form-label">Subtitle <span class="text-secondary">(optional)</span></label>
    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $fi?->subtitle) }}" maxlength="255" placeholder="e.g. 2024/2025">
    <small class="form-hint">A short line shown below the title, like a season or year.</small>
</div>

<div class="row mb-3 align-items-start">
    <div class="col-auto">
        <div class="avatar avatar-xl rounded border" style="width:64px;height:64px;background-color:#fff;">
            @if ($previewUrl)
                <img src="{{ $previewUrl }}" alt="Preview" id="footer-img-preview" class="w-100 h-100" style="object-fit:contain;">
            @else
                <i class="ti ti-photo-filled text-secondary" style="opacity:.3;font-size:1.5rem;" id="footer-img-placeholder"></i>
                <img src="" alt="Preview" id="footer-img-preview" class="w-100 h-100 d-none" style="object-fit:contain;">
            @endif
        </div>
    </div>
    <div class="col">
        <label class="form-label">Image</label>
        <input type="text" name="image_path" class="form-control" value="{{ old('image_path', $fi?->image_path) }}" maxlength="512" placeholder="/static/image/footer/example.png" id="footer-img-path">
        <small class="form-hint">Path to the image file on the server, or a full URL starting with https://</small>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Link URL <span class="text-secondary">(optional)</span></label>
    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $fi?->link_url) }}" maxlength="512" placeholder="https://example.com">
    <small class="form-hint">Opens when a visitor clicks this entry. Leave empty for no link.</small>
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $fi?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first.</small>
</div>

@push('scripts')
<script>
(function () {
    const pathInput = document.getElementById('footer-img-path');
    const img = document.getElementById('footer-img-preview');
    const placeholder = document.getElementById('footer-img-placeholder');
    const appBase = @json(rtrim((string) config('app.url'), '/'));

    if (!pathInput || !img) return;

    pathInput.addEventListener('input', function () {
        const v = this.value.trim();
        if (!v) {
            img.classList.add('d-none');
            if (placeholder) placeholder.classList.remove('d-none');
            return;
        }
        img.src = v.startsWith('http') ? v : (v.startsWith('/') ? appBase + v : appBase + '/' + v);
        img.classList.remove('d-none');
        if (placeholder) placeholder.classList.add('d-none');
    });
})();
</script>
@endpush
