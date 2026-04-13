@extends('admin.layout')

@section('pretitle', 'Content')
@section('title', 'Menus')

@section('actions')
    <a href="{{ route('admin.navigation.create') }}" class="btn btn-primary">
        <i class="ti ti-circle-plus-filled me-1"></i>Add link
    </a>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="ti ti-device-desktop-filled me-2"></i>Desktop top bar</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th style="width:4rem">#</th>
                    <th>Label</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($desktopItems as $item)
                    <tr>
                        <td class="text-secondary">{{ $item->sort_order }}</td>
                        <td class="fw-medium">{{ $item->label_bn }}</td>
                        <td class="text-secondary text-break" style="max-width:220px">{{ $item->href }}</td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'bg-success-lt' : 'bg-secondary-lt' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.navigation.edit', $item) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.navigation.destroy', $item) }}" method="post" onsubmit="return confirm('Remove this link?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">No links in this section.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="ti ti-device-mobile-filled me-2"></i>Mobile drawer</h3>
        </div>
        <div class="card-body p-0">
            @php
                $groups = ['top' => 'Top section', 'games' => 'Games', 'others' => 'Other links'];
                $idx = 0;
            @endphp
            <div class="accordion" id="drawerAccordion">
                @foreach ($groups as $key => $label)
                    @php $items = $drawerGroups->get($key, collect()); $idx++; @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $idx > 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#grp-{{ $key }}">
                                {{ $label }}
                                <span class="badge bg-secondary ms-auto">{{ $items->count() }}</span>
                            </button>
                        </h2>
                        <div id="grp-{{ $key }}" class="accordion-collapse collapse {{ $idx === 1 ? 'show' : '' }}" data-bs-parent="#drawerAccordion">
                            <div class="table-responsive">
                                <table class="table table-vcenter mb-0">
                                    <thead>
                                    <tr>
                                        <th style="width:4rem">#</th>
                                        <th>Label</th>
                                        <th>URL</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th class="w-1"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td class="text-secondary">{{ $item->sort_order }}</td>
                                            <td class="fw-medium">{{ $item->label_bn }}</td>
                                            <td class="text-secondary text-break" style="max-width:180px">{{ $item->href }}</td>
                                            <td>
                                                @if ($item->icon_path)
                                                    <img src="{{ asset(ltrim($item->icon_path, '/')) }}" width="20" height="20" class="rounded" style="object-fit:contain">
                                                @else
                                                    <span class="text-secondary">&mdash;</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->is_active ? 'bg-success-lt' : 'bg-secondary-lt' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="{{ route('admin.navigation.edit', $item) }}" class="btn btn-sm">Edit</a>
                                                    <form action="{{ route('admin.navigation.destroy', $item) }}" method="post" onsubmit="return confirm('Remove this link?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-ghost-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center text-secondary py-3">Empty</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
