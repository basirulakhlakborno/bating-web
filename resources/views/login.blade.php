@extends('layouts.babu88')

@section('content')
<div data-app="true" class="v-application v-application--is-ltr theme--light" id="app">
    <div class="v-application--wrap">
        <div>
            <x-app-shell-top />

            <div class="body auth-page-body">
                <div class="auth-page-main">
                    <div class="row no-gutters justify-center">
                        @include('partials.auth.login-panel')
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
@include('partials.auth.auth-ajax-submit')
<script>
(function () {
    var pwd = document.getElementById('login-password');
    var toggle = document.querySelector('.login-password-toggle');
    if (pwd && toggle) {
        toggle.addEventListener('click', function () {
            var show = pwd.getAttribute('type') === 'password';
            pwd.setAttribute('type', show ? 'text' : 'password');
            toggle.classList.toggle('mdi-eye', !show);
            toggle.classList.toggle('mdi-eye-off', show);
            toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    }
    initAuthAjaxForm('.login-form-page', {
        errorId: 'login-ajax-errors',
        successMessage: 'সফলভাবে লগইন হয়েছে।'
    });
})();
</script>
@endpush
