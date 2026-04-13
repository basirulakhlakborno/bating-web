@extends('admin.layout')

@section('pretitle', 'Users')
@section('title', 'Players')

@section('actions')
    <form action="{{ route('admin.users.index') }}" method="get" class="d-flex gap-2">
        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search username, email or phone…" style="min-width:220px">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
        @if (request('search'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        @endif
    </form>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Joined</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="text-secondary">{{ $user->id }}</td>
                        <td class="fw-medium">{{ $user->username }}</td>
                        <td class="text-secondary">{{ $user->phone ?? '—' }}</td>
                        <td class="fw-medium">৳{{ number_format($user->balance, 2) }}</td>
                        <td class="text-secondary">{{ $user->created_at?->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-secondary-lt">{{ $user->role }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">
                            @if (request('search'))
                                No players matching "{{ request('search') }}".
                            @else
                                No players have registered yet.
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $users->links() }}</div>
        @endif
    </div>
@endsection
