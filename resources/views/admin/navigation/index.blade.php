@extends('admin.layout')

@section('title', 'Navigation')

@section('content')
    <h1>Navigation</h1>
    <p>Desktop bar and mobile drawer links. Edit labels, URLs, icons, and drawer JSON meta (<code>{"variant":"referral"}</code>, <code>{"badge":"নতুন"}</code>, <code>{"icon_wrap":"button"}</code>).</p>
    <table>
        <thead>
        <tr>
            <th>Placement</th>
            <th>Group</th>
            <th>Sort</th>
            <th>Label (BN)</th>
            <th>Href</th>
            <th>Active</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->placement }}</td>
                <td>{{ $item->drawer_group }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>{{ $item->label_bn }}</td>
                <td style="word-break:break-all;">{{ $item->href }}</td>
                <td>{{ $item->is_active ? 'Yes' : 'No' }}</td>
                <td><a href="{{ route('admin.navigation.edit', $item) }}">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
