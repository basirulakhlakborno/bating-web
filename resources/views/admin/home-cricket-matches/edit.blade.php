@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Edit home cricket highlight')

@section('content')
    <form action="{{ route('admin.home-cricket-matches.update', $match) }}" method="post" class="card">
        <div class="card-body">
            @csrf @method('PUT')
            @include('admin.home-cricket-matches._form', ['match' => $match])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.home-cricket-matches.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
