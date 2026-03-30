@extends('admin.layout')

@section('title', 'Edit game')

@section('content')
    <h1>Edit game</h1>
    <form action="{{ route('admin.games.update', $game) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.games._form', ['categories' => $categories, 'game' => $game])
        <button type="submit" class="btn">Save</button>
    </form>
@endsection
