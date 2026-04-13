@php $n = $item ?? null; @endphp

<div class="mb-3">
    <label class="form-label">Where this link appears</label>
    <select name="placement" class="form-select">
        @foreach (['desktop_nav' => 'Top bar (computer)', 'drawer' => 'Slide-out menu (phone)'] as $val => $label)
            <option value="{{ $val }}" @selected(old('placement', $n?->placement) === $val)>{{ $label }}</option>
        @endforeach
    </select>
    <small class="form-hint">Top bar shows on large screens; slide-out menu opens from the side on phones.</small>
</div>
<div class="mb-3">
    <label class="form-label">Section in the slide-out menu</label>
    <select name="drawer_group" class="form-select">
        <option value="">— Not used for top bar —</option>
        @foreach (['top' => 'Top', 'games' => 'Games', 'others' => 'Other links'] as $val => $label)
            <option value="{{ $val }}" @selected(old('drawer_group', $n?->drawer_group) === $val)>{{ $label }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Label (Bengali)</label>
    <input type="text" name="label_bn" class="form-control" value="{{ old('label_bn', $n?->label_bn) }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Label (English, optional)</label>
    <input type="text" name="label_en" class="form-control" value="{{ old('label_en', $n?->label_en) }}">
</div>
<div class="mb-3">
    <label class="form-label">Link address</label>
    <input type="text" name="href" class="form-control" value="{{ old('href', $n?->href) }}" required maxlength="512" placeholder="/page or https://…">
    <small class="form-hint">The page or site this menu item opens.</small>
</div>
<div class="mb-3">
    <label class="form-label">Menu icon <span class="text-secondary">(slide-out menu)</span></label>
    <input type="text" name="icon_path" class="form-control" value="{{ old('icon_path', $n?->icon_path) }}" maxlength="512" placeholder="Path to image, if used">
</div>
<div class="mb-3">
    <label class="form-label">Sort order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $n?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first.</small>
</div>

<details class="mb-3">
    <summary class="fw-medium mb-2" style="cursor: pointer;">Advanced options (for developers)</summary>
    <div class="ps-3 border-start">
        <div class="mb-3">
            <label class="form-label">Badge style (desktop)</label>
            <select name="badge_variant" class="form-select">
                <option value="dot" @selected(old('badge_variant', $n?->badge_variant) === 'dot')>Dot</option>
                <option value="hot" @selected(old('badge_variant', $n?->badge_variant) === 'hot')>Hot</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Label CSS classes</label>
            <input type="text" name="label_class" class="form-control" value="{{ old('label_class', $n?->label_class) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Extra menu options (JSON)</label>
            <textarea name="drawer_meta_json" class="form-control font-monospace small" rows="4" placeholder="{}">{{ old('drawer_meta_json', json_encode($n?->drawer_meta ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
            <small class="form-hint">Leave as-is unless your team asked you to change it.</small>
        </div>
    </div>
</details>

<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $n?->is_active ?? true))>
        <span class="form-check-label">Show on the website</span>
    </label>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_external" value="1" class="form-check-input" @checked(old('is_external', $n?->is_external ?? false))>
        <span class="form-check-label">Opens a different website</span>
    </label>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="has_badge_ui" value="1" class="form-check-input" @checked(old('has_badge_ui', $n?->has_badge_ui ?? false))>
        <span class="form-check-label">Show badge on desktop</span>
    </label>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="show_underline" value="1" class="form-check-input" @checked(old('show_underline', $n?->show_underline ?? false))>
        <span class="form-check-label">Underline on desktop</span>
    </label>
</div>
