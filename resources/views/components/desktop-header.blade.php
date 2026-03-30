<div class="row hidden-sm-and-down header-top no-gutters align-center justify-space-between">
    <div class="header-column col col-5">
        <a href="{{ url('/') }}" class="router-link-exact-active router-link-active">
            <img src="/static/svg/bb88_logo_animation2.gif" alt="" width="312" height="58" style="float: left;">
        </a>
    </div>
    <div class="header-column register-dialog text-right col-md-6 col-lg-5 col-5">
        @auth
            @php($u = auth()->user())
            <div class="greeting-text font-weight-bold">
                <label class="color-primary greeting-text-btn">{{ $u->displayUsername() }}</label>
                <button type="button" class="circle v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default">
                    <span class="v-btn__content">
                        <img src="/static/image/other/vector.svg" alt="Vector Image" width="20" height="20">
                    </span>
                </button>
                <a href="{{ url('/profile/inbox') }}" class="circle v-btn v-btn--is-elevated v-btn--has-bg v-btn--router theme--light v-size--default">
                    <span class="v-btn__content">
                        <img src="/static/image/other/notification.svg" alt="email image" width="20" height="20">
                        @if(($inboxUnread ?? 0) > 0)
                            <span top="" right="" class="v-badge theme--light" style="z-index: 10;">
                                <span class="v-badge__wrapper">
                                    <span aria-atomic="true" aria-label="Badge" aria-live="polite" role="status" class="v-badge__badge" style="inset: auto auto calc(100% + 0px) calc(100% + 0px); background-color: rgb(0, 128, 246); border-color: rgb(0, 128, 246);">{{ (int) $inboxUnread }}</span>
                                </span>
                            </span>
                        @endif
                    </span>
                </a>
                <hr role="separator" aria-orientation="vertical" class="v-divider v-divider--vertical theme--light">
                <span class="color-base header-wallet v-chip v-chip--clickable v-chip--no-color v-chip--pill theme--light v-size--default">
                    <span class="v-chip__content">
                        <label class="text-capitalize balance">
                            <span>{{ $u->currencySymbol() }} {{ number_format((float) $u->balance, 2) }}</span>
                        </label>
                    </span>
                </span>
                <div style="position: relative; display: inline-block;">
                    <button type="button" class="v-icon notranslate color-primary header-wallet-icon v-icon--left v-icon--link material-icons theme--light" style="font-size: 50px; color: rgb(0, 128, 246) !important; z-index: 1;">add_circle</button>
                </div>
                <button type="button" class="pt-0 language_container v-btn v-btn--icon v-btn--round theme--light v-size--small">
                    <span class="v-btn__content">
                        <div style="display: flex; align-items: center;">
                            <div class="v-avatar language-button" style="height: 40px; min-width: 40px; width: 40px;">
                                <img src="/static/image/country/{{ strtoupper($u->currency_code ?? 'BDT') }}.svg" alt="">
                            </div>
                            <i aria-hidden="true" class="v-icon notranslate mdi mdi-menu-down theme--light"></i>
                        </div>
                    </span>
                </button>
                <form action="{{ route('logout') }}" method="post" class="d-inline-block" style="vertical-align: middle;">
                    @csrf
                    <button type="submit" class="elevation-0 v-btn v-btn--icon v-btn--round theme--light v-size--small" title="{{ __('Log out') }}">
                        <span class="v-btn__content">
                            <img src="/static/svg/mobileMenu/logout.svg" alt="" width="30" height="30" style="fill: rgb(58, 58, 58);">
                        </span>
                    </button>
                </form>
            </div>
        @else
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
                                    <img src="/static/image/country/BDT.svg" alt="">
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
        @endauth
    </div>
</div>

{{-- ============================================ --}}
