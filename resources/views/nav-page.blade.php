@extends('layouts.babu88')

@section('content')
<div data-app="true" class="v-application v-application--is-ltr theme--light" id="app">
    <div class="v-application--wrap">
        <div>
            <x-app-shell-top />

            <div class="body auth-page-body">
                <div class="auth-page-main">
                    <div class="row no-gutters justify-center py-8 px-5">
                        <div class="col col-12 col-lg-10 col-xl-8">
                            <h1 class="login-header text-center py-2">{{ $heading ?? ($title ?? 'Page') }}</h1>
                            <p class="login-header-desc text-center pt-2">
                                {{ $description ?? 'এই পৃষ্ঠার সম্পূর্ণ কনটেন্ট শীঘ্রই যুক্ত করা হবে।' }}
                            </p>
                        </div>
                    </div>
                </div>

                <x-footer />
            </div>

            <x-bottom-nav />

            <x-global-overlays />
        </div>
    </div>

    <x-sub-navigators />
</div>
@endsection

@push('styles')
@include('partials.auth.auth-page-styles')
@endpush

@push('scripts')
<script src="/js/home-interactions.js"></script>
@endpush
