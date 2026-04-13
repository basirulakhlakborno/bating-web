@extends('admin.layout')

@section('pretitle', 'Game categories')
@section('title', 'Add category')

@section('content')
    <form action="{{ route('admin.game-categories.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.game-categories._form')
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.game-categories.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add category</button>
        </div>
    </form>
@endsection
