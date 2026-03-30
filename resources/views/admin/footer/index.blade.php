@extends('admin.layout')

@section('title', 'Footer')

@section('content')
    <h1>Footer sections</h1>
    @foreach ($sections as $section)
        <h2>{{ $section->title_bn }} <small>({{ $section->slug }})</small></h2>
        <p><a href="{{ route('admin.footer.items.create', $section) }}" class="btn">Add entry</a></p>
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Image</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($section->items as $it)
                <tr>
                    <td>{{ $it->title }}</td>
                    <td>{{ $it->subtitle }}</td>
                    <td style="word-break:break-all;">{{ $it->image_path }}</td>
                    <td><a href="{{ route('admin.footer.items.edit', $it) }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
