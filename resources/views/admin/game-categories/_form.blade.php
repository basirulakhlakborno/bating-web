@php $c = $category ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Short name for links</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $c?->slug) }}" required maxlength="64" placeholder="e.g. slot">
    <small class="form-hint">Letters, numbers, and dashes only. Used in web addresses.</small>
</div>
<div class="mb-3">
    <label class="form-label">Name (Bengali)</label>
    <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn', $c?->name_bn) }}" required maxlength="255" placeholder="e.g. স্লট">
</div>
<div class="mb-3">
    <label class="form-label">Name (English) <span class="text-secondary">(optional)</span></label>
    <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $c?->name_en) }}" maxlength="255" placeholder="e.g. Slot">
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $c?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first.</small>
</div>
