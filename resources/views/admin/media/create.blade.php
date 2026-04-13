@extends('admin.layout')

@section('pretitle', 'Media library')
@section('title', 'Add asset')

@section('content')
    <form action="{{ route('admin.media.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.media._form', ['categories' => $categories])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.media.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add asset</button>
        </div>
    </form>
@endsection
