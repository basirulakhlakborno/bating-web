@extends('admin.layout')

@section('pretitle', 'Users')
@section('title', 'Messages')

@section('actions')
    <a href="{{ route('admin.messages.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Send message
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th>Recipient</th>
                    <th>Title</th>
                    <th>Sent</th>
                    <th>Read</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($messages as $msg)
                    <tr>
                        <td class="fw-medium">{{ $msg->user?->username ?? 'All players' }}</td>
                        <td>{{ Str::limit($msg->title, 50) }}</td>
                        <td class="text-secondary">{{ $msg->sent_at?->diffForHumans() }}</td>
                        <td>
                            <span class="badge {{ $msg->is_read ? 'bg-success-lt' : 'bg-secondary-lt' }}">{{ $msg->is_read ? 'Read' : 'Unread' }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.messages.destroy', $msg) }}" method="post" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">No messages sent yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($messages->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $messages->links() }}</div>
        @endif
    </div>
@endsection
