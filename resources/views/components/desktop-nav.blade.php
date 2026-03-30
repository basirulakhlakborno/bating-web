{{-- DESKTOP NAVIGATION BAR (database: navigation_items.placement = desktop_nav) --}}
<div class="page-navigator hidden-sm-and-down">
    @foreach ($layoutDesktopNav ?? [] as $item)
        @include('components.partials.desktop-nav-item', ['item' => $item])
    @endforeach
</div>
