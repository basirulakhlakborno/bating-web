<style>
    .auth-page-body {
        background-color: #2e2e2e;
        padding-bottom: 0;
    }
    .auth-page-main {
        background-color: #fff;
        padding: 16px 0 32px;
    }
    @media (min-width: 600px) {
        .auth-page-main {
            padding: 24px 0 40px;
        }
    }
    .auth-page-body .auth-panel-outer {
        padding-left: clamp(12px, 4vw, 40px);
        padding-right: clamp(12px, 4vw, 40px);
    }
    .auth-page-body .auth-form-vform {
        margin: 0 !important;
        padding: 18px 16px !important;
    }
    @media (min-width: 600px) {
        .auth-page-body .auth-form-vform {
            padding: 24px 28px !important;
        }
    }
    @media (min-width: 960px) {
        .auth-page-body .auth-form-vform {
            padding: 32px !important;
        }
    }
    .auth-page-body .login-form-bg {
        background-color: #fff !important;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
    }
    .auth-page-body .login-submit-btn.v-btn,
    .auth-page-body .register-submit-btn.v-btn {
        width: 100%;
        min-height: 60px !important;
        padding: 16px 22px !important;
        font-size: 1.125rem !important;
        border-radius: 8px;
    }
    .auth-page-body .register-submit-btn.v-btn {
        background: linear-gradient(180deg, #ffe082 0%, #ffce01 45%, #f0b800 100%) !important;
        color: #111 !important;
        border: 1px solid rgba(0, 0, 0, 0.16) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
    }
    .auth-page-body .register-submit-btn.v-btn .v-btn__content {
        color: #111 !important;
        font-weight: 700 !important;
    }
    .auth-page-body .register-submit-btn.v-btn:hover {
        filter: brightness(0.98);
    }
    .auth-page-body .register-submit-btn.v-btn:active {
        filter: brightness(0.93);
    }
    .auth-page-body a.auth-to-register-cta.v-btn {
        background: linear-gradient(180deg, #ffe082 0%, #ffce01 45%, #f0b800 100%) !important;
        color: #111 !important;
        border: 1px solid rgba(0, 0, 0, 0.16) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
    }
    .auth-page-body a.auth-to-register-cta .v-btn__content {
        color: #111 !important;
        font-weight: 700 !important;
    }
    .auth-page-body a.auth-to-register-cta.v-btn:hover {
        filter: brightness(0.98);
    }
    .auth-page-body .login-forgot-row {
        margin-top: 14px;
    }
    .auth-page-body .login-forgot-row .login-forgot-btn {
        display: block !important;
        width: 100% !important;
        max-width: 100%;
        margin: 0 auto !important;
        height: auto !important;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        color: #0094ff !important;
        font-size: 14px !important;
    }
    .auth-page-body .register-currency-field {
        position: relative;
        width: 100%;
        max-width: 100%;
    }
    .auth-page-body .register-currency-vinput {
        margin-top: 0;
        padding-top: 0;
        width: 100%;
        max-width: 100%;
    }
    .auth-page-body .register-currency-vinput .v-input__control {
        width: 100%;
        max-width: 100%;
        flex: 1 1 auto;
    }
    .auth-page-body .register-currency-selections {
        flex: 1 1 auto;
        min-width: 0;
    }
    .auth-page-body .register-currency-trigger-avatar img {
        object-fit: cover;
        border-radius: 50%;
    }
    .auth-page-body .register-currency-trigger {
        cursor: pointer;
        user-select: none;
        align-items: center;
        display: flex;
        flex-wrap: nowrap;
        min-height: 56px;
    }
    .auth-page-body .register-currency-trigger:focus {
        outline: none;
    }
    .auth-page-body .register-currency-trigger:focus-visible {
        outline: 2px solid rgba(0, 148, 255, 0.4);
        outline-offset: 2px;
    }
    .auth-page-body .register-currency-dropdown {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 4px);
        z-index: 20;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        padding: 4px 0;
        max-height: 280px;
        overflow-y: auto;
    }
    .auth-page-body .register-currency-option {
        display: flex;
        align-items: center;
        width: 100%;
        border: none;
        background: #fff;
        cursor: pointer;
        text-align: left;
        padding: 10px 16px;
        gap: 12px;
        font-size: 16px;
        font-family: Roboto, sans-serif;
        color: rgba(0, 0, 0, 0.87);
    }
    .auth-page-body .register-currency-option:hover {
        background: rgba(0, 0, 0, 0.04);
    }
    .auth-page-body .register-currency-option:focus {
        outline: none;
    }
    .auth-page-body .register-currency-option:focus-visible {
        outline: 2px solid rgba(0, 148, 255, 0.45);
        outline-offset: -2px;
        background: rgba(0, 0, 0, 0.04);
    }
    .auth-page-body .register-currency-option-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .auth-page-body .register-currency-option-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .auth-page-body .register-captcha-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px 14px;
    }
    .auth-page-body .register-captcha-field {
        flex: 1 1 220px;
        min-width: 0;
    }
    .auth-page-body .register-captcha-field .v-input__control,
    .auth-page-body .register-captcha-field .v-input__slot {
        max-width: 100%;
    }
    .auth-page-body .register-captcha-side {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex: 1 1 auto;
        min-width: 0;
    }
    .auth-page-body .register-captcha-img-wrap {
        line-height: 0;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        overflow: hidden;
        background: #f5f5f5;
        max-width: min(148px, 100%);
    }
    .auth-page-body .register-captcha-img {
        display: block;
        width: 100%;
        max-width: 148px;
        height: auto;
        aspect-ratio: 148 / 48;
        object-fit: contain;
        vertical-align: middle;
    }
    @media (max-width: 599px) {
        .auth-page-body .register-captcha-side {
            flex: 1 1 100%;
            justify-content: center;
        }
        .auth-page-body .register-captcha-img-wrap {
            max-width: min(168px, 92vw);
        }
    }
    .auth-page-body .register-captcha-refresh.v-btn {
        flex-shrink: 0;
    }
    .auth-page-body .reg-desktop-prefix {
        min-width: 0;
    }
    @media (max-width: 359px) {
        .auth-page-body .register_panel .row.no-gutters .col-4 {
            flex: 0 0 30%;
            max-width: 30%;
        }
        .auth-page-body .register_panel .row.no-gutters .col-8 {
            flex: 0 0 70%;
            max-width: 70%;
        }
    }
    .auth-page-body .register-referral-details {
        overflow: hidden;
    }
    .auth-page-body .register-referral-summary {
        cursor: pointer;
        list-style: none;
        padding: 10px 0;
        font-weight: 500;
        width: 100%;
        box-sizing: border-box;
        gap: 8px;
    }
    .auth-page-body .register-referral-summary:focus {
        outline: none;
    }
    .auth-page-body .register-referral-summary:focus-visible {
        outline: 2px solid rgba(0, 148, 255, 0.35);
        outline-offset: 2px;
        border-radius: 4px;
    }
    .auth-page-body .register-referral-summary::-webkit-details-marker,
    .auth-page-body .register-referral-summary::marker {
        display: none;
        content: '';
    }
    .auth-page-body .register-referral-chevron {
        font-size: 28px !important;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
        opacity: 0.75;
    }
    .auth-page-body .register-referral-details[open] .register-referral-chevron {
        transform: rotate(180deg);
    }
    .auth-page-body .register-referral-panel {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.32s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .auth-page-body .register-referral-details[open] .register-referral-panel {
        grid-template-rows: 1fr;
    }
    .auth-page-body .register-referral-panel-inner {
        overflow: hidden;
        min-height: 0;
    }
    @media (prefers-reduced-motion: reduce) {
        .auth-page-body .register-referral-chevron,
        .auth-page-body .register-referral-panel {
            transition-duration: 0.05s;
        }
    }
    .auth-page-body .register-terms-label {
        cursor: pointer;
        user-select: none;
        width: 100%;
        box-sizing: border-box;
        outline: none;
    }
    /* Keyboard focus only — mouse clicks should not draw a box around the whole row */
    .auth-page-body .register-terms-label:has(.register-terms-checkbox-input:focus-visible) {
        outline: 2px solid rgba(0, 148, 255, 0.35);
        outline-offset: 2px;
        border-radius: 4px;
    }
    .auth-page-body .register-terms-checkbox-input {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
        margin: 0;
        padding: 0;
        pointer-events: none;
        clip: rect(0, 0, 0, 0);
    }
    .auth-page-body .register-terms-checkbox-icon {
        font-size: 24px !important;
    }
    .auth-page-body .register-terms-col .v-input--selection-controls__input {
        position: relative;
    }
    .auth-page-body .v-text-field__slot input,
    .auth-page-body .v-text-field__slot textarea {
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }
    .auth-page-body .login-form-bg {
        width: 100%;
        max-width: 100%;
    }
    .auth-page-body .register_panel .login-form-bg {
        max-width: min(100%, 720px);
        margin-left: auto;
        margin-right: auto;
    }
</style>
