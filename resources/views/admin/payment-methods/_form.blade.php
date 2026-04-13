@php $m = $method ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $m?->name) }}" required maxlength="255" placeholder="e.g. bKash">
</div>
<div class="mb-3">
    <label class="form-label">Image / logo</label>
    <input type="text" name="image_path" class="form-control" value="{{ old('image_path', $m?->image_path) }}" maxlength="512" placeholder="/static/svg/bkash.svg">
    <small class="form-hint">Path to the icon file on the server or a full URL.</small>
    @if ($m?->image_path)
        <div class="mt-2">
            <img src="{{ str_starts_with($m->image_path, 'http') ? $m->image_path : asset(ltrim($m->image_path, '/')) }}" alt="" class="rounded border shadow-sm" style="max-height: 60px;">
        </div>
    @endif
</div>
<div class="mb-3">
    <label class="form-label">Description / alt text <span class="text-secondary">(optional)</span></label>
    <input type="text" name="alt" class="form-control" value="{{ old('alt', $m?->alt) }}" maxlength="255">
</div>
<div class="mb-3">
    <label class="form-label">Link URL <span class="text-secondary">(optional)</span></label>
    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $m?->link_url) }}" maxlength="512" placeholder="https://…">
    <small class="form-hint">If the logo should link somewhere when clicked.</small>
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $m?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first.</small>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $m?->is_active ?? true))>
        <span class="form-check-label">Show on the website</span>
    </label>
</div>
