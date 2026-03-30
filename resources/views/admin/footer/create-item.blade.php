@extends('admin.layout')

@section('title', 'Add footer entry')

@section('content')
    <h1>Add footer entry — {{ $section->title_bn }}</h1>
    <form action="{{ route('admin.footer.items.store', $section) }}" method="post">
        @csrf
        @include('admin.footer._item-form', ['footerItem' => null])
        <button type="submit" class="btn">Create</button>
        <a href="{{ route('admin.footer.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
