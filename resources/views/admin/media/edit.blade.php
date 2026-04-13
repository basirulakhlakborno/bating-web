@extends('admin.layout')

@section('pretitle', 'Media library')
@section('title', 'Edit asset')

@section('content')
    <form action="{{ route('admin.media.update', $asset) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.media._form', ['asset' => $asset, 'categories' => $categories])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.media.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
