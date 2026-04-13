@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Home cricket highlights')

@section('actions')
    <a href="{{ route('admin.home-cricket-matches.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add match
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th class="w-1">Order</th>
                    <th>League</th>
                    <th>Teams</th>
                    <th>Starts</th>
                    <th>Status</th>
                    <th>On site</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($matches as $row)
                    <tr>
                        <td class="text-secondary">{{ $row->sort_order }}</td>
                        <td>
                            <div class="fw-medium">{{ $row->league_name }}</div>
                        </td>
                        <td>
                            <div class="small">{{ $row->team1_name }}</div>
                            <div class="small text-secondary">vs {{ $row->team2_name }}</div>
                        </td>
                        <td class="text-secondary small">{{ $row->match_starts_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            @if ($row->status === 'live')
                                <span class="badge bg-red-lt">Live</span>
                            @else
                                <span class="badge bg-azure-lt">Upcoming</span>
                            @endif
                        </td>
                        <td>
                            @if ($row->is_active)
                                <span class="badge bg-success-lt">Yes</span>
                            @else
                                <span class="badge bg-secondary-lt">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.home-cricket-matches.edit', $row) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.home-cricket-matches.destroy', $row) }}" method="post" onsubmit="return confirm('Delete this highlight?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-secondary">No highlights yet. Add matches shown on the player homepage.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
