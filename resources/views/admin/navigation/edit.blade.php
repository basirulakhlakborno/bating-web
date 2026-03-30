@extends('admin.layout')

@section('title', 'Edit navigation')

@section('content')
    <h1>Edit navigation</h1>
    <form action="{{ route('admin.navigation.update', $item) }}" method="post">
        @csrf
        @method('PUT')
        <div class="stack">
            <label>Placement</label>
            <select name="placement">
                @foreach (['desktop_nav', 'drawer'] as $p)
                    <option value="{{ $p }}" @selected(old('placement', $item->placement) === $p)>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="stack">
            <label>Drawer group (drawer only)</label>
            <select name="drawer_group">
                <option value="">—</option>
                @foreach (['top', 'games', 'others'] as $g)
                    <option value="{{ $g }}" @selected(old('drawer_group', $item->drawer_group) === $g)>{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div class="stack">
            <label>Label (Bengali)</label>
            <input type="text" name="label_bn" value="{{ old('label_bn', $item->label_bn) }}" required>
        </div>
        <div class="stack">
            <label>Label (English, optional)</label>
            <input type="text" name="label_en" value="{{ old('label_en', $item->label_en) }}">
        </div>
        <div class="stack">
            <label>Href</label>
            <input type="text" name="href" value="{{ old('href', $item->href) }}" required maxlength="512">
        </div>
        <div class="stack">
            <label>Icon path (drawer)</label>
            <input type="text" name="icon_path" value="{{ old('icon_path', $item->icon_path) }}" maxlength="512">
        </div>
        <div class="stack">
            <label>Sort order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0">
        </div>
        <div class="stack">
            <label>Badge variant (desktop)</label>
            <select name="badge_variant">
                @foreach (['dot', 'hot'] as $v)
                    <option value="{{ $v }}" @selected(old('badge_variant', $item->badge_variant) === $v)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="stack">
            <label>Label CSS classes (desktop)</label>
            <input type="text" name="label_class" value="{{ old('label_class', $item->label_class) }}">
        </div>
        <div class="stack">
            <label>Drawer meta (JSON object, optional)</label>
            <textarea name="drawer_meta_json" rows="6">{{ old('drawer_meta_json', json_encode($item->drawer_meta ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
        </div>
        <div class="stack">
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active))> Active</label>
        </div>
        <div class="stack">
            <label><input type="checkbox" name="is_external" value="1" @checked(old('is_external', $item->is_external))> External link</label>
        </div>
        <div class="stack">
            <label><input type="checkbox" name="has_badge_ui" value="1" @checked(old('has_badge_ui', $item->has_badge_ui))> Desktop badge wrapper</label>
        </div>
        <div class="stack">
            <label><input type="checkbox" name="show_underline" value="1" @checked(old('show_underline', $item->show_underline))> Desktop underline</label>
        </div>
        <button type="submit" class="btn">Save</button>
        <a href="{{ route('admin.navigation.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
