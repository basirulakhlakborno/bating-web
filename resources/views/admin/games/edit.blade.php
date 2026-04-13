@extends('admin.layout')

@section('pretitle', 'Games')
@section('title', 'Edit game')

@section('content')
    <form action="{{ route('admin.games.update', $game) }}" method="post" enctype="multipart/form-data" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.games._form', ['categories' => $categories, 'game' => $game])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.games.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
