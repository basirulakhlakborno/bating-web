@extends('admin.layout')

@section('pretitle', 'Social links')
@section('title', 'Edit social link')

@section('content')
    <form action="{{ route('admin.social-links.update', $link) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.social-links._form', ['link' => $link])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.social-links.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
