@extends('admin.layout')

@section('pretitle', 'Messages')
@section('title', 'Send message')

@section('content')
    <form action="{{ route('admin.messages.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            <div class="mb-3">
                <label class="form-label">Send to</label>
                <select name="recipient" class="form-select" id="msg-recipient">
                    <option value="single" @selected(old('recipient') === 'single')>One player</option>
                    <option value="all" @selected(old('recipient') === 'all')>All players</option>
                </select>
            </div>
            <div class="mb-3" id="msg-username-field">
                <label class="form-label">Player username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Enter username">
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
            </div>
            <div class="mb-3">
                <label class="form-label">Message body</label>
                <textarea name="body" class="form-control" rows="6" required maxlength="5000">{{ old('body') }}</textarea>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Send message</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function() {
    var sel = document.getElementById('msg-recipient');
    var field = document.getElementById('msg-username-field');
    if (!sel || !field) return;
    function toggle() { field.style.display = sel.value === 'single' ? '' : 'none'; }
    sel.addEventListener('change', toggle);
    toggle();
})();
</script>
@endpush
