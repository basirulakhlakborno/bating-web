@extends('admin.layout')

@section('pretitle', 'Game categories')
@section('title', 'Edit category')

@section('content')
    <form action="{{ route('admin.game-categories.update', $category) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.game-categories._form', ['category' => $category])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.game-categories.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
