<style>
    .auth-page-body {
        background-color: #2e2e2e;
        padding-bottom: 0;
    }
    .auth-page-main {
        background-color: #fff;
        padding: 24px 0 40px;
    }
    .auth-page-body .login-form-bg {
        background-color: #fff !important;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
    }
    .auth-page-body .login-form-page,
    .auth-page-body .register-form-page {
        padding: 24px !important;
    }
    @media (min-width: 960px) {
        .auth-page-body .login-form-page,
        .auth-page-body .register-form-page {
            padding: 32px !important;
        }
    }
    .auth-page-body .login-submit-btn.v-btn,
    .auth-page-body .register-submit-btn.v-btn {
        width: 100%;
        min-height: 60px !important;
        padding: 16px 22px !important;
        font-size: 1.125rem !important;
        border-radius: 8px;
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
    .auth-page-body .register-form-page select.register-currency-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(0, 0, 0, 0.38);
        border-radius: 4px;
        font-size: 16px;
        background: #fff;
        box-sizing: border-box;
    }
    .auth-page-body .register-captcha-canvas {
        display: block;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        background: #f5f5f5;
        vertical-align: middle;
    }
    .auth-page-body .register-referral-details summary {
        cursor: pointer;
        list-style: none;
        padding: 8px 0;
        font-weight: 500;
    }
    .auth-page-body .register-referral-details summary::-webkit-details-marker {
        display: none;
    }
</style>
