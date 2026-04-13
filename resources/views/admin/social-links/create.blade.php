@extends('admin.layout')

@section('pretitle', 'Social links')
@section('title', 'Add social link')

@section('content')
    <form action="{{ route('admin.social-links.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.social-links._form')
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.social-links.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add link</button>
        </div>
    </form>
@endsection
