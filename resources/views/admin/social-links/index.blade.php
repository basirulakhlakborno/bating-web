@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Social links')

@section('actions')
    <a href="{{ route('admin.social-links.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add link
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
                    <th>URL</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($links as $l)
                    <tr>
                        <td>
                            @if ($l->icon_path)
                                <span class="avatar avatar-sm rounded" style="background-image: url('{{ str_starts_with($l->icon_path, 'http') ? $l->icon_path : asset(ltrim($l->icon_path, '/')) }}'); background-color: #fff;"></span>
                            @else
                                <span class="avatar avatar-sm rounded bg-light"><i class="ti ti-link text-secondary" style="font-weight:900"></i></span>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $l->label }}</td>
                        <td class="text-secondary text-break" style="max-width:280px">{{ $l->url }}</td>
                        <td>
                            <span class="badge {{ $l->is_active ? 'bg-success-lt' : 'bg-secondary-lt' }}">{{ $l->is_active ? 'Active' : 'Hidden' }}</span>
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.social-links.edit', $l) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.social-links.destroy', $l) }}" method="post" onsubmit="return confirm('Delete this link?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">No social links yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
