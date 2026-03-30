@extends('admin.layout')

@section('title', 'Edit footer entry')

@section('content')
    <h1>Edit footer entry</h1>
    <form action="{{ route('admin.footer.items.update', $footerItem) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.footer._item-form', ['footerItem' => $footerItem])
        <button type="submit" class="btn">Save</button>
        <a href="{{ route('admin.footer.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
