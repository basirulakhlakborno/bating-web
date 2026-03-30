@extends('admin.layout')

@section('title', 'Add game')

@section('content')
    <h1>Add game</h1>
    <form action="{{ route('admin.games.store') }}" method="post">
        @csrf
        @include('admin.games._form', ['categories' => $categories, 'game' => null])
        <button type="submit" class="btn">Create</button>
    </form>
@endsection
