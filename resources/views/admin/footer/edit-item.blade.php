@extends('admin.layout')

@section('pretitle', 'Footer')
@section('title', 'Edit entry')

@section('content')
    <form action="{{ route('admin.footer.items.update', $footerItem) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.footer._item-form', ['footerItem' => $footerItem])
        </div>
        <div class="card-footer d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.footer.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
