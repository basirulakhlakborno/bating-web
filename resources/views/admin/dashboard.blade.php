@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="row row-deck row-cards">

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Total players</div>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ number_format($stats['players']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Games listed</div>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ number_format($stats['games']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Pending deposits</div>
                    </div>
                    <div class="h1 mb-0 mt-2">
                        {{ $stats['deposits_pending'] }}
                        @if ($stats['deposits_pending'] > 0)
                            <span class="ms-1 badge bg-warning text-dark">needs review</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Pending withdrawals</div>
                    </div>
                    <div class="h1 mb-0 mt-2">
                        {{ $stats['withdrawals_pending'] }}
                        @if ($stats['withdrawals_pending'] > 0)
                            <span class="ms-1 badge bg-warning text-dark">needs review</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent deposits</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.deposits.index') }}" class="btn btn-link">View all</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Player</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentDeposits as $d)
                            <tr>
                                <td>{{ $d->user?->username ?? '—' }}</td>
                                <td class="fw-medium">{{ number_format($d->amount, 2) }}</td>
                                <td>
                                    @if ($d->status === 'approved' || $d->status === 'confirmed')
                                        <span class="badge bg-success-lt">{{ ucfirst($d->status) }}</span>
                                    @elseif ($d->status === 'rejected')
                                        <span class="badge bg-danger-lt">Rejected</span>
                                    @else
                                        <span class="badge bg-warning-lt">Pending</span>
                                    @endif
                                </td>
                                <td class="text-secondary">{{ $d->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary">No deposits yet</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent withdrawals</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-link">View all</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th>Player</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentWithdrawals as $w)
                            <tr>
                                <td>{{ $w->user?->username ?? '—' }}</td>
                                <td class="fw-medium">{{ number_format($w->amount, 2) }}</td>
                                <td>{{ $w->method }}</td>
                                <td>
                                    @if ($w->status === 'approved' || $w->status === 'completed')
                                        <span class="badge bg-success-lt">{{ ucfirst($w->status) }}</span>
                                    @elseif ($w->status === 'rejected')
                                        <span class="badge bg-danger-lt">Rejected</span>
                                    @else
                                        <span class="badge bg-warning-lt">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary">No withdrawals yet</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick access</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.games.create') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-circle-plus-filled fs-2"></i>
                                <span class="small">Add game</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.messages.create') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-mail-filled fs-2"></i>
                                <span class="small">Send message</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.navigation.create') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-layout-list-filled fs-2"></i>
                                <span class="small">Add menu link</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.payment-methods.create') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-credit-card-filled fs-2"></i>
                                <span class="small">Add payment</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.media.create') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-photo-filled fs-2"></i>
                                <span class="small">Add media</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route('admin.settings.edit') }}" class="btn w-100 py-3 btn-outline-primary d-flex flex-column align-items-center gap-1">
                                <i class="ti ti-settings-filled fs-2"></i>
                                <span class="small">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
