@extends('admin.layout')

@section('pretitle', 'Finance')
@section('title', 'Payment methods')

@section('actions')
    <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add method
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
                    <th>Sort</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($methods as $m)
                    <tr>
                        <td>
                            @if ($m->image_path)
                                <span class="avatar rounded" style="background-image: url('{{ str_starts_with($m->image_path, 'http') ? $m->image_path : asset(ltrim($m->image_path, '/')) }}'); background-color: #fff;"></span>
                            @else
                                <span class="avatar rounded bg-light"><i class="ti ti-credit-card-filled text-secondary"></i></span>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $m->name }}</td>
                        <td class="text-secondary">{{ $m->sort_order }}</td>
                        <td>
                            <span class="badge {{ $m->is_active ? 'bg-success-lt' : 'bg-secondary-lt' }}">{{ $m->is_active ? 'Active' : 'Hidden' }}</span>
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.payment-methods.edit', $m) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.payment-methods.destroy', $m) }}" method="post" onsubmit="return confirm('Delete this method?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">No payment methods yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
