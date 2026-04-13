@extends('admin.layout')

@section('pretitle', 'Finance')
@section('title', 'Deposits')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All deposits</h3>
            <div class="card-actions">
                <form method="get" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm" style="width:auto">
                        <option value="">All</option>
                        @foreach (['pending', 'approved', 'confirmed', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control form-control-sm" style="width:12rem" placeholder="Search…" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-primary">Filter</button>
                    @if (request('status') || request('search'))
                        <a href="{{ route('admin.deposits.index') }}" class="btn btn-sm">Clear</a>
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
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="w-1">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($deposits as $d)
                    <tr>
                        <td class="text-secondary">{{ $d->id }}</td>
                        <td class="fw-medium">{{ $d->user?->username ?? '—' }}</td>
                        <td>{{ number_format($d->amount, 2) }} <span class="text-secondary">{{ $d->currency_code }}</span></td>
                        <td class="text-secondary text-break" style="max-width:140px">{{ $d->reference }}</td>
                        <td>
                            @if ($d->status === 'approved' || $d->status === 'confirmed')
                                <span class="badge bg-success-lt">{{ ucfirst($d->status) }}</span>
                            @elseif ($d->status === 'rejected')
                                <span class="badge bg-danger-lt">Rejected</span>
                            @else
                                <span class="badge bg-warning-lt">Pending</span>
                            @endif
                        </td>
                        <td class="text-secondary">{{ $d->created_at?->format('d M Y, H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.deposits.status', $d) }}" method="post" class="d-flex gap-1">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width:auto">
                                    @foreach (['pending', 'approved', 'rejected'] as $s)
                                        <option value="{{ $s }}" @selected($d->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm">Set</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary py-4">No deposits found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($deposits->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $deposits->links() }}</div>
        @endif
    </div>
@endsection
