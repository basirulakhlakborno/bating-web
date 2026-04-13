@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Media library')

@section('actions')
    <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add asset
    </a>
@endsection

@section('content')
    @forelse ($grouped as $category => $assets)
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">{{ ucfirst($category ?: 'Uncategorised') }}</h3>
                <div class="card-actions"><span class="badge bg-secondary">{{ $assets->count() }}</span></div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>Slug</th>
                        <th>Path</th>
                        <th class="w-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($assets as $a)
                        @php $src = str_starts_with($a->path, 'http') ? $a->path : asset(ltrim($a->path, '/')); @endphp
                        <tr>
                            <td>
                                <span class="avatar rounded" style="background-image: url('{{ $src }}'); background-color: #fff;"></span>
                            </td>
                            <td class="fw-medium">{{ $a->slug }}</td>
                            <td class="text-secondary text-break" style="max-width:280px">{{ $a->path }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('admin.media.edit', $a) }}" class="btn btn-sm">Edit</a>
                                    <form action="{{ route('admin.media.destroy', $a) }}" method="post" onsubmit="return confirm('Delete this asset?')">
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
    @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-3"><i class="ti ti-photo-filled" style="font-size:3rem; opacity:.3"></i></div>
                <h3>No media assets yet</h3>
                <p class="text-secondary">Upload banners, logos, and icons for your site.</p>
                <a href="{{ route('admin.media.create') }}" class="btn btn-primary">Add first asset</a>
            </div>
        </div>
    @endforelse
@endsection
