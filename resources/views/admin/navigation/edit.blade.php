@extends('admin.layout')

@section('pretitle', 'Menus')
@section('title', 'Edit menu link')

@section('content')
    <form action="{{ route('admin.navigation.update', $item) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.navigation._form', ['item' => $item])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.navigation.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
