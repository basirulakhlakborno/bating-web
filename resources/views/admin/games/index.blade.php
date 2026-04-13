@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Games')

@section('actions')
    <a href="{{ route('admin.games.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add game
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th class="w-1"></th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($games as $game)
                    @php
                        $tp = $game->thumbnail_path;
                        $thumbSrc = $tp
                            ? (str_starts_with($tp, 'http') ? $tp : asset(ltrim($tp, '/')))
                            : null;
                    @endphp
                    <tr>
                        <td>
                            @if ($thumbSrc)
                                <button type="button" class="btn btn-link p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#gameImageModal" data-img-src="{{ $thumbSrc }}" data-img-title="{{ $game->title }}">
                                    <span class="avatar avatar-lg rounded" style="background-image: url('{{ $thumbSrc }}')"></span>
                                </button>
                            @else
                                <span class="avatar avatar-lg rounded bg-light"><i class="ti ti-photo-filled text-secondary" style="opacity:.4"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $game->title }}</div>
                            <div class="text-secondary small">{{ $game->provider }}</div>
                        </td>
                        <td class="text-secondary">{{ $game->slug }}</td>
                        <td>{{ $game->category?->name_bn }}</td>
                        <td>
                            @if ($game->is_featured)
                                <span class="badge bg-yellow-lt">Featured</span>
                            @else
                                <span class="text-secondary">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if ($game->is_active)
                                <span class="badge bg-success-lt">Active</span>
                            @else
                                <span class="badge bg-secondary-lt">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.games.destroy', $game) }}" method="post" onsubmit="return confirm('Delete this game?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal modal-blur fade" id="gameImageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gameImageModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img src="" alt="" id="gameImageModalImg" class="img-fluid rounded" style="max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('gameImageModal')?.addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    if (!btn) return;
    document.getElementById('gameImageModalImg').src = btn.dataset.imgSrc || '';
    document.getElementById('gameImageModalTitle').textContent = btn.dataset.imgTitle || '';
});
</script>
@endpush
