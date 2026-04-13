@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Footer')

@section('content')
    @foreach ($sections as $section)
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">{{ $section->title_bn }}</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.footer.items.create', $section) }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-circle-plus-filled me-1"></i>Add entry
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th class="w-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($section->items as $it)
                        @php
                            $ip = $it->image_path;
                            $footerImg = $ip ? (str_starts_with($ip, 'http') ? $ip : asset(ltrim($ip, '/'))) : null;
                        @endphp
                        <tr>
                            <td>
                                @if ($footerImg)
                                    <span class="avatar rounded" style="background-image: url('{{ $footerImg }}'); background-color: #fff;"></span>
                                @else
                                    <span class="avatar rounded bg-light"><i class="ti ti-photo-filled text-secondary" style="opacity:.4"></i></span>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $it->title }}</td>
                            <td class="text-secondary">{{ $it->subtitle }}</td>
                            <td>
                                <a href="{{ route('admin.footer.items.edit', $it) }}" class="btn btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endsection
