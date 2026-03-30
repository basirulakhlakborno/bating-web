@php
    $g = $game;
@endphp
<div class="stack">
    <label>Category</label>
    <select name="game_category_id" required>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('game_category_id', $g?->game_category_id) == $cat->id)>{{ $cat->name_bn }} ({{ $cat->slug }})</option>
        @endforeach
    </select>
</div>
<div class="stack">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $g?->title) }}" required maxlength="255">
</div>
<div class="stack">
    <label>Slug</label>
    <input type="text" name="slug" value="{{ old('slug', $g?->slug) }}" required maxlength="255">
</div>
<div class="stack">
    <label>Provider</label>
    <input type="text" name="provider" value="{{ old('provider', $g?->provider) }}" maxlength="255">
</div>
<div class="stack">
    <label>Thumbnail path</label>
    <input type="text" name="thumbnail_path" value="{{ old('thumbnail_path', $g?->thumbnail_path) }}" maxlength="512" placeholder="/static/...">
</div>
<div class="stack">
    <label>Link (href)</label>
    <input type="text" name="href" value="{{ old('href', $g?->href) }}" maxlength="512" placeholder="/slot">
</div>
<div class="stack">
    <label>Sort order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $g?->sort_order ?? 0) }}" min="0">
</div>
<div class="stack">
    <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $g?->is_active ?? true))> Active</label>
</div>
<div class="stack">
    <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $g?->is_featured ?? false))> Featured on home</label>
</div>
