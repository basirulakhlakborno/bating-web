<div class="row hidden-sm-and-down header-top no-gutters align-center justify-space-between">
    <div class="header-column col col-5">
        <a href="/" class="router-link-exact-active router-link-active">
            <img src="/static/svg/bb88_logo_animation2.gif" alt="" width="312" height="58" style="float: left;">
        </a>
    </div>
    <div class="header-column register-dialog text-right col-md-6 col-lg-5 col-5">
        <!---->
        <div class="row no-gutters justify-end">
            <div class="text-right hidden-sm-and-down col col-12">
                <a href="{{ url('/login') }}" class="mr-6 embedded-login-button pa-2 font-weight-bold black--text subtitle-1 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none" style="height: auto; background-color: rgb(255, 206, 1); border-color: rgb(255, 206, 1); border-radius: 8px; font-size: 14px !important;">
                    <span class="v-btn__content">
                        লগইন করুন
                    </span>
                </a>
                <a href="{{ url('/register') }}" class="full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default subtitle-1 full-width font-weight-bold white--text pa-2 embedded-register-button mr-6 text-decoration-none" style="background-color: rgb(0, 128, 246); border-radius: 8px; font-size: 14px !important;">
                    <span class="v-btn__content">
                        এখনি যোগদিন
                    </span>
                </a>
                <button type="button" class="currency-language-dialog-trigger pt-0 language_container v-btn v-btn--icon v-btn--round theme--light v-size--small">
                    <span class="v-btn__content">
                        <div style="display: flex; align-items: center;">
                            <div class="v-avatar language-button" style="height: 40px; min-width: 40px; width: 40px;">
                                <img src="/static/image/country/BDT.svg">
                            </div>
                            <i aria-hidden="true" class="v-icon notranslate largerIcon mdi mdi-menu-down theme--light">
                            </i>
                        </div>
                    </span>
                </button>
            </div>
            <div class="text-right hidden-md-and-up col col-12">
                <a href="{{ url('/login') }}" class="mr-1 primary-button embedded-mobile-login-button font-weight-bold yellow--text v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default black text-decoration-none">
                    <span class="v-btn__content">
                        লগইন করুন
                    </span>
                </a>
                <a href="{{ url('/register') }}" class="full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default buttonPrimary theme-button embedded-mobile-register-button text-decoration-none">
                    <span class="v-btn__content">
                        নিবন্ধন করুন
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ============================================ --}}
