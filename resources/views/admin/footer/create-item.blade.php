@extends('admin.layout')

@section('pretitle', 'Footer')
@section('title', 'Add entry — {{ $section->title_bn }}')

@section('content')
    <form action="{{ route('admin.footer.items.store', $section) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.footer._item-form', ['footerItem' => null])
        </div>
        <div class="card-footer d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.footer.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
@endsection
