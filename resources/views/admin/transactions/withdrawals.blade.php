@extends('admin.layout')

@section('pretitle', 'Finance')
@section('title', 'Withdrawals')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All withdrawals</h3>
            <div class="card-actions">
                <form method="get" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm" style="width:auto">
                        <option value="">All</option>
                        @foreach (['pending', 'approved', 'completed', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control form-control-sm" style="width:12rem" placeholder="Search…" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-primary">Filter</button>
                    @if (request('status') || request('search'))
                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-sm">Clear</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Player</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Account</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="w-1">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($withdrawals as $w)
                    <tr>
                        <td class="text-secondary">{{ $w->id }}</td>
                        <td class="fw-medium">{{ $w->user?->username ?? '—' }}</td>
                        <td>{{ number_format($w->amount, 2) }} <span class="text-secondary">{{ $w->currency_code }}</span></td>
                        <td>{{ $w->method }}</td>
                        <td class="text-secondary">{{ $w->account_phone }}</td>
                        <td>
                            @if ($w->status === 'approved' || $w->status === 'completed')
                                <span class="badge bg-success-lt">{{ ucfirst($w->status) }}</span>
                            @elseif ($w->status === 'rejected')
                                <span class="badge bg-danger-lt">Rejected</span>
                            @else
                                <span class="badge bg-warning-lt">Pending</span>
                            @endif
                        </td>
                        <td class="text-secondary">{{ $w->created_at?->format('d M Y, H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.withdrawals.status', $w) }}" method="post" class="d-flex gap-1">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width:auto">
                                    @foreach (['pending', 'approved', 'rejected'] as $s)
                                        <option value="{{ $s }}" @selected($w->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm">Set</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-secondary py-4">No withdrawals found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($withdrawals->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $withdrawals->links() }}</div>
        @endif
    </div>
@endsection
