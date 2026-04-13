@php $a = $asset ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Slug (unique name)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $a?->slug) }}" required maxlength="255" placeholder="e.g. register-banner-bd">
    <small class="form-hint">Letters, numbers, and dashes. Used internally to find this item.</small>
</div>
<div class="mb-3">
    <label class="form-label">File path or URL</label>
    <input type="text" name="path" class="form-control" value="{{ old('path', $a?->path) }}" required maxlength="512" placeholder="/static/image/banner.jpg or https://…">
    <small class="form-hint">Where the image lives on the server or the web.</small>
    @if ($a?->path)
        <div class="mt-2 p-2 bg-light rounded border">
            <img src="{{ str_starts_with($a->path, 'http') ? $a->path : asset(ltrim($a->path, '/')) }}" alt="{{ $a->alt }}" class="rounded shadow-sm" style="max-height: 120px; max-width: 100%;">
        </div>
    @endif
</div>
<div class="mb-3">
    <label class="form-label">Description / alt text <span class="text-secondary">(optional)</span></label>
    <input type="text" name="alt" class="form-control" value="{{ old('alt', $a?->alt) }}" maxlength="255" placeholder="Short description of the image">
</div>
<div class="mb-3">
    <label class="form-label">Category</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $a?->category) }}" maxlength="64" placeholder="e.g. banner, logo, payment-icon" list="category-suggestions">
    <small class="form-hint">Group similar items together (banner, logo, payment-icon, etc.).</small>
    @if (isset($categories) && $categories->isNotEmpty())
        <datalist id="category-suggestions">
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">
            @endforeach
        </datalist>
    @endif
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $a?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first within the same category.</small>
</div>
