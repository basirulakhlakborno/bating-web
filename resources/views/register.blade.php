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
@include('partials.auth.auth-ajax-submit')
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

    function refreshRegisterCaptcha() {
        var img = document.getElementById('register-captcha-img');
        if (!img) return;
        var base = img.getAttribute('data-captcha-url') || img.src.split('?')[0];
        img.src = base + (base.indexOf('?') >= 0 ? '&' : '?') + 't=' + Date.now();
    }
    window.refreshRegisterCaptcha = refreshRegisterCaptcha;

    var captchaRefresh = document.getElementById('register-captcha-refresh');
    if (captchaRefresh) {
        captchaRefresh.addEventListener('click', function (e) {
            e.preventDefault();
            refreshRegisterCaptcha();
            var input = document.getElementById('register-captcha-input');
            if (input) input.value = '';
        });
    }

    (function initRegisterCurrency() {
        var root = document.querySelector('[data-register-currency]');
        if (!root) return;
        var trigger = root.querySelector('.register-currency-trigger');
        var menu = root.querySelector('[data-register-currency-menu]');
        var hidden = root.querySelector('.register-currency-hidden');
        var flagImg = root.querySelector('.register-currency-trigger-flag');
        var textEl = root.querySelector('.register-currency-trigger-text');
        if (!trigger || !menu || !hidden || !flagImg || !textEl) return;
        function setOpen(open) {
            menu.hidden = !open;
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            setOpen(menu.hidden);
        });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                setOpen(menu.hidden);
            }
            if (e.key === 'Escape') setOpen(false);
        });
        menu.querySelectorAll('.register-currency-option').forEach(function (btn) {
            btn.addEventListener('click', function () {
                hidden.value = btn.getAttribute('data-currency-code') || '';
                flagImg.src = btn.getAttribute('data-currency-flag') || '';
                textEl.textContent = btn.getAttribute('data-currency-label') || '';
                setOpen(false);
            });
        });
        document.addEventListener('click', function (e) {
            if (!root.contains(e.target)) setOpen(false);
        });
    })();

    (function initRegisterTermsCheckbox() {
        var cb = document.getElementById('register-terms');
        var icon = document.querySelector('.register-terms-checkbox-icon');
        if (!cb || !icon) return;
        function syncTermsCheckboxVisual() {
            var on = cb.checked;
            if (on) {
                icon.classList.remove('mdi-checkbox-blank-outline');
                icon.classList.add('mdi-checkbox-marked');
            } else {
                icon.classList.add('mdi-checkbox-blank-outline');
                icon.classList.remove('mdi-checkbox-marked');
            }
            icon.classList.toggle('primary--text', on);
            cb.setAttribute('aria-checked', on ? 'true' : 'false');
        }
        cb.addEventListener('change', syncTermsCheckboxVisual);
        syncTermsCheckboxVisual();
    })();

    initAuthAjaxForm('.register-form-page', {
        errorId: 'register-ajax-errors',
        successMessage: 'নিবন্ধন সম্পন্ন। স্বাগতম!',
        afterError: function () {
            refreshRegisterCaptcha();
        }
    });
})();
</script>
@endpush
