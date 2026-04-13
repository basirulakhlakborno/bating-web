@php $l = $link ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="label" class="form-control" value="{{ old('label', $l?->label) }}" required maxlength="255" placeholder="e.g. Facebook">
</div>
<div class="mb-3">
    <label class="form-label">URL</label>
    <input type="url" name="url" class="form-control" value="{{ old('url', $l?->url) }}" required maxlength="512" placeholder="https://facebook.com/…">
</div>
<div class="mb-3">
    <label class="form-label">Icon image <span class="text-secondary">(optional)</span></label>
    <input type="text" name="icon_path" class="form-control" value="{{ old('icon_path', $l?->icon_path) }}" maxlength="512" placeholder="/static/svg/facebook.svg">
    @if ($l?->icon_path)
        <div class="mt-2">
            <img src="{{ str_starts_with($l->icon_path, 'http') ? $l->icon_path : asset(ltrim($l->icon_path, '/')) }}" alt="" class="rounded border shadow-sm" style="max-height: 40px;">
        </div>
    @endif
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $l?->sort_order ?? 0) }}" min="0">
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $l?->is_active ?? true))>
        <span class="form-check-label">Show on the website</span>
    </label>
</div>
