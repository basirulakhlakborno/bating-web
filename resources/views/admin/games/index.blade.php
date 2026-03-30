@extends('admin.layout')

@section('title', 'Games')

@section('content')
    <h1>Games</h1>
    <p><a href="{{ route('admin.games.create') }}" class="btn">Add game</a></p>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Category</th>
            <th>Featured</th>
            <th>Active</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($games as $game)
            <tr>
                <td>{{ $game->title }}</td>
                <td>{{ $game->slug }}</td>
                <td>{{ $game->category?->name_bn }}</td>
                <td>{{ $game->is_featured ? 'Yes' : '' }}</td>
                <td>{{ $game->is_active ? 'Yes' : '' }}</td>
                <td>
                    <a href="{{ route('admin.games.edit', $game) }}">Edit</a>
                    <form action="{{ route('admin.games.destroy', $game) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this game?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding:4px 10px;">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
