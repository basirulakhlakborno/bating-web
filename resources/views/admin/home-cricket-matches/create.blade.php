@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Add home cricket highlight')

@section('content')
    <form action="{{ route('admin.home-cricket-matches.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.home-cricket-matches._form', ['match' => null])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.home-cricket-matches.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
@endsection
