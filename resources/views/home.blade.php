@extends('layouts.babu88')

@section('content')
<div data-app="true" class="v-application v-application--is-ltr theme--light" id="app">
    <div class="v-application--wrap">
        <div>
            <x-app-shell-top />

            {{-- Main Body Content --}}
            <div class="body">
                <div class="bg_home">
                    @include('partials.home.banner')
                    <!---->

                    @include('partials.home.bg-filter')
                </div>

                <x-footer />
            </div>
            <!---->

            <x-bottom-nav />

            <x-global-overlays />
        </div>
    </div>

    <x-sub-navigators />
</div>
@endsection

@push('scripts')
<script src="/js/home-interactions.js"></script>
@endpush
