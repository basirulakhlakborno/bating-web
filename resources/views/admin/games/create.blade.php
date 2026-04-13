@extends('admin.layout')

@section('pretitle', 'Games')
@section('title', 'Add game')

@section('content')
    <form action="{{ route('admin.games.store') }}" method="post" enctype="multipart/form-data" class="card">
        <div class="card-body">
            @csrf
            @include('admin.games._form', ['categories' => $categories, 'game' => null])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.games.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add game</button>
        </div>
    </form>
@endsection
