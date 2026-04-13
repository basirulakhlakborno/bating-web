@php
    $g = $game;
    $thumbPath = old('thumbnail_path', $g?->thumbnail_path);
    $previewUrl = '';
    if ($thumbPath) {
        $previewUrl = str_starts_with($thumbPath, 'http') ? $thumbPath : asset(ltrim($thumbPath, '/'));
    }
@endphp

<div class="mb-3">
    <label class="form-label">Game type</label>
    <select name="game_category_id" class="form-select" required>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('game_category_id', $g?->game_category_id) == $cat->id)>{{ $cat->name_bn }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Game name</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $g?->title) }}" required maxlength="255" placeholder="e.g. Fortune Gems">
</div>
<div class="mb-3">
    <label class="form-label">Short name for links</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $g?->slug) }}" required maxlength="255" placeholder="e.g. fortune-gems">
    <small class="form-hint">Use letters, numbers, and dashes only. This appears in the website address.</small>
</div>
<div class="mb-3">
    <label class="form-label">Studio / provider <span class="text-secondary">(optional)</span></label>
    <input type="text" name="provider" class="form-control" value="{{ old('provider', $g?->provider) }}" maxlength="255" placeholder="e.g. JILI">
</div>

<div class="card mb-4 border-primary border-opacity-25">
    <div class="card-header bg-primary bg-opacity-10">
        <h3 class="card-title mb-0"><i class="ti ti-photo-filled me-2"></i>Cover picture</h3>
        <div class="card-subtitle text-secondary mt-1">This image is shown to players in the game list. Use a clear square or wide image.</div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-start">
            <div class="col-md-5 col-lg-4">
                <div class="ratio ratio-1x1 bg-light rounded border d-flex align-items-center justify-content-center overflow-hidden" style="max-height: 240px;">
                    <div id="thumb-preview-placeholder" class="text-center text-secondary p-3 {{ $previewUrl ? 'd-none' : '' }}">
                        <i class="ti ti-photo-filled" style="font-size: 3rem; opacity:.3;"></i>
                        <p class="small mb-0 mt-2">No picture yet</p>
                    </div>
                    <img
                        src="{{ $previewUrl ?: 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' }}"
                        alt="Preview"
                        class="w-100 h-100 p-2 {{ $previewUrl ? '' : 'd-none' }}"
                        style="object-fit: contain;"
                        id="thumb-preview-img"
                        data-initial-src="{{ $previewUrl }}"
                    >
                </div>
            </div>
            <div class="col-md-7 col-lg-8">
                <label class="form-label">Upload from your computer</label>
                <div
                    class="border border-2 border-dashed rounded-3 p-4 text-center user-select-none thumb-dropzone bg-light"
                    id="thumb-dropzone"
                    role="button"
                    tabindex="0"
                >
                    <i class="ti ti-cloud-upload fs-1 text-primary"></i>
                    <p class="mb-1 mt-2 fw-medium">Drag a file here or click to choose</p>
                    <p class="small text-muted mb-3">JPG, PNG, GIF, or WebP — up to 4&nbsp;MB</p>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="thumb-browse-btn">
                        <i class="ti ti-folder-filled me-1"></i> Choose picture
                    </button>
                    <input type="file" name="thumbnail" id="thumbnail-input" class="d-none" accept="image/jpeg,image/png,image/gif,image/webp">
                </div>
                @if ($g && $thumbPath)
                    <div class="form-check mt-3">
                        <input type="checkbox" name="remove_thumbnail" value="1" class="form-check-input" id="remove_thumbnail" @checked(old('remove_thumbnail'))>
                        <label class="form-check-label text-danger" for="remove_thumbnail">Delete this picture</label>
                    </div>
                @endif
            </div>
        </div>

        <details class="mt-4">
            <summary class="mb-2 fw-medium" style="cursor: pointer;">For technical staff: use a file path instead</summary>
            <p class="small text-muted mb-2">Only if your team already hosts images on the server. Leave empty when using upload above.</p>
            <input type="text" name="thumbnail_path" class="form-control" value="{{ old('thumbnail_path', $g?->thumbnail_path) }}" maxlength="512" placeholder="Path starting with / …" autocomplete="off" id="thumbnail-path-input">
        </details>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Where the game opens</label>
    <input type="text" name="href" class="form-control" value="{{ old('href', $g?->href) }}" maxlength="512" placeholder="e.g. /slot">
    <small class="form-hint">The page that opens when someone taps this game.</small>
</div>
<div class="mb-3">
    <label class="form-label">Order in the list</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $g?->sort_order ?? 0) }}" min="0">
    <small class="form-hint">Lower numbers appear first.</small>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $g?->is_active ?? true))>
        <span class="form-check-label">Show this game on the website</span>
    </label>
</div>
<div class="mb-3">
    <label class="form-check">
        <input type="checkbox" name="is_featured" value="1" class="form-check-input" @checked(old('is_featured', $g?->is_featured ?? false))>
        <span class="form-check-label">Highlight on the homepage</span>
    </label>
</div>

@push('scripts')
<script>
(function () {
    const input = document.getElementById('thumbnail-input');
    const dropzone = document.getElementById('thumb-dropzone');
    const browseBtn = document.getElementById('thumb-browse-btn');
    const img = document.getElementById('thumb-preview-img');
    const placeholder = document.getElementById('thumb-preview-placeholder');
    const removeCb = document.getElementById('remove_thumbnail');
    const pathInput = document.getElementById('thumbnail-path-input');
    const appBase = @json(rtrim((string) config('app.url'), '/'));

    function showPreviewFromFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            if (placeholder) placeholder.classList.add('d-none');
            if (img) {
                img.classList.remove('d-none');
                img.src = e.target.result;
            }
            if (removeCb) removeCb.checked = false;
        };
        reader.readAsDataURL(file);
    }

    if (input) {
        input.addEventListener('change', function () {
            const f = this.files && this.files[0];
            if (f) showPreviewFromFile(f);
        });
    }

    function openPicker() {
        if (input) input.click();
    }

    if (browseBtn) browseBtn.addEventListener('click', function (e) { e.preventDefault(); openPicker(); });
    if (dropzone) {
        dropzone.addEventListener('click', function (e) {
            if (e.target === browseBtn || browseBtn.contains(e.target)) return;
            openPicker();
        });
        dropzone.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openPicker(); }
        });
        ['dragenter', 'dragover'].forEach(function (ev) {
            dropzone.addEventListener(ev, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-primary', 'bg-white');
            });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            dropzone.addEventListener(ev, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-primary', 'bg-white');
            });
        });
        dropzone.addEventListener('drop', function (e) {
            const f = e.dataTransfer.files && e.dataTransfer.files[0];
            if (!f || !input) return;
            try {
                const dt = new DataTransfer();
                dt.items.add(f);
                input.files = dt.files;
            } catch (err) {
                return;
            }
            showPreviewFromFile(f);
        });
    }

    if (removeCb && img && placeholder) {
        removeCb.addEventListener('change', function () {
            if (this.checked) {
                img.classList.add('d-none');
                placeholder.classList.remove('d-none');
            } else {
                const init = img.getAttribute('data-initial-src') || '';
                if (init) {
                    img.src = init;
                    img.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
            }
        });
    }

    if (pathInput && img && placeholder) {
        pathInput.addEventListener('input', function () {
            const v = this.value.trim();
            if (!v) return;
            if (v.startsWith('http')) {
                img.src = v;
            } else {
                img.src = v.startsWith('/') ? appBase + v : appBase + '/' + v;
            }
            img.classList.remove('d-none');
            placeholder.classList.add('d-none');
            if (removeCb) removeCb.checked = false;
        });
    }
})();
</script>
@endpush
