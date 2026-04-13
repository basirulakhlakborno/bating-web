@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Game categories')

@section('actions')
    <a href="{{ route('admin.game-categories.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add category
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th>Bengali name</th>
                    <th>English name</th>
                    <th>Slug</th>
                    <th>Games</th>
                    <th>Sort</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $c)
                    <tr>
                        <td class="fw-medium">{{ $c->name_bn }}</td>
                        <td>{{ $c->name_en ?? '—' }}</td>
                        <td class="text-secondary">{{ $c->slug }}</td>
                        <td><span class="badge bg-primary-lt">{{ $c->games_count }}</span></td>
                        <td class="text-secondary">{{ $c->sort_order }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.game-categories.edit', $c) }}" class="btn btn-sm">Edit</a>
                                @if ($c->games_count === 0)
                                    <form action="{{ route('admin.game-categories.destroy', $c) }}" method="post" onsubmit="return confirm('Delete this category?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">No categories yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
