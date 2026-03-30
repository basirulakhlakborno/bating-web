@extends('layouts.babu88')

@section('content')
<div data-app="true" class="v-application v-application--is-ltr theme--light" id="app">
    <div class="v-application--wrap">
        <div>
            <x-app-shell-top />

            <div class="body auth-page-body">
                <div class="auth-page-main">
                    <div class="row no-gutters justify-center">
                        @include('partials.auth.register-panel')
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
<script>
(function () {
    function bindPasswordToggle(toggle, inputId) {
        var input = document.getElementById(inputId);
        if (!input || !toggle) return;
        toggle.addEventListener('click', function () {
            var show = input.getAttribute('type') === 'password';
            input.setAttribute('type', show ? 'text' : 'password');
            toggle.classList.toggle('mdi-eye', !show);
            toggle.classList.toggle('mdi-eye-off', show);
            toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    }
    bindPasswordToggle(document.querySelector('[data-register-pw-toggle="reg-pass"]'), 'register-password');
    bindPasswordToggle(document.querySelector('[data-register-pw-toggle="reg-pass2"]'), 'register-password-confirm');

    function drawCaptcha() {
        var canvas = document.getElementById('register-captcha-canvas');
        if (!canvas || !canvas.getContext) return;
        var ctx = canvas.getContext('2d');
        var code = '';
        var chars = 'ABCDEFGHJKLMNPQRSTUVW23456789';
        for (var i = 0; i < 4; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
        canvas.dataset.expectedCode = code;
        ctx.fillStyle = '#eeeeee';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        for (var j = 0; j < 6; j++) {
            ctx.strokeStyle = 'rgba(0,0,0,' + (0.08 + Math.random() * 0.12) + ')';
            ctx.beginPath();
            ctx.moveTo(Math.random() * 68, Math.random() * 40);
            ctx.lineTo(Math.random() * 68, Math.random() * 40);
            ctx.stroke();
        }
        ctx.fillStyle = '#1a1a1a';
        ctx.font = 'bold 18px monospace';
        ctx.fillText(code, 10, 27);
    }
    drawCaptcha();
    var refresh = document.getElementById('register-captcha-refresh');
    if (refresh) refresh.addEventListener('click', function (e) { e.preventDefault(); drawCaptcha(); });
})();
</script>
@endpush
