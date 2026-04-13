@extends('admin.layout')

@section('pretitle', 'Menus')
@section('title', 'Add menu link')

@section('content')
    <form action="{{ route('admin.navigation.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.navigation._form')
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.navigation.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add link</button>
        </div>
    </form>
@endsection
