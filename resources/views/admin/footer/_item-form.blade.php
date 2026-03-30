@php $fi = $footerItem; @endphp
<div class="stack">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $fi?->title) }}" required maxlength="255">
</div>
<div class="stack">
    <label>Subtitle (e.g. season)</label>
    <input type="text" name="subtitle" value="{{ old('subtitle', $fi?->subtitle) }}" maxlength="255">
</div>
<div class="stack">
    <label>Image path</label>
    <input type="text" name="image_path" value="{{ old('image_path', $fi?->image_path) }}" maxlength="512">
</div>
<div class="stack">
    <label>Link URL (optional)</label>
    <input type="text" name="link_url" value="{{ old('link_url', $fi?->link_url) }}" maxlength="512">
</div>
<div class="stack">
    <label>Sort order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $fi?->sort_order ?? 0) }}" min="0">
</div>
