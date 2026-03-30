<div class="full-width hidden-md-and-up header-top mobile elevation-3 col col-12">
    <div class="row no-gutters align-center">
        <div class="px-3 col col-12">
            <div class="row no-gutters align-center justify-space-between">
                <div class="text-left col col-1">
                    <button type="button" class="v-app-bar__nav-icon v-btn v-btn--icon v-btn--round theme--light v-size--default" height="18" width="22" style="height: 18px; width: 22px;">
                        <span class="v-btn__content">
                            <i aria-hidden="true" class="v-icon notranslate mdi mdi-menu theme--light"></i>
                        </span>
                    </button>
                </div>
                <div class="mobile-header-logo col col-9">
                    <a href="{{ url('/') }}" class="router-link-exact-active router-link-active" style="display: flex; align-items: center;">
                        <img src="/static/svg/bb88_logo_animation2.gif" alt="" width="215" height="45">
                    </a>
                </div>
                <div class="text-right col col-2 d-flex align-center justify-end logged-in-mobile-toolbar" style="gap: 2px; flex-wrap: nowrap;">
                    @auth
                        <a href="{{ url('/profileAccount') }}" class="logged-in-header-right account-btn v-btn v-btn--icon v-btn--round v-btn--router theme--light v-size--default" title="{{ __('Account') }}">
                            <span class="v-btn__content">
                                <img src="/static/image/other/icon_account.svg" alt="" width="22" height="22" style="display: block;">
                            </span>
                        </a>
                        <a href="{{ url('/profile/inbox') }}" class="logged-in-header-right v-btn v-btn--icon v-btn--round v-btn--router theme--light v-size--default" title="ইনবক্স">
                            <span class="v-btn__content">
                                <span class="v-badge v-badge--dot v-badge--overlap theme--light" style="display: inline-flex; align-items: center; justify-content: center;">
                                    <img src="/static/image/other/icon_notification.svg" alt="" width="22" height="22" style="display: block;">
                                    @if(($inboxUnread ?? 0) > 0)
                                        <span class="v-badge__wrapper">
                                            <span aria-atomic="true" aria-label="Badge" aria-live="polite" role="status" class="v-badge__badge" style="inset: auto auto calc(100% - 6px) calc(100% - 6px); background-color: rgb(0, 128, 246); border-color: rgb(0, 128, 246); min-width: 8px; min-height: 8px;"></span>
                                        </span>
                                    @endif
                                </span>
                            </span>
                        </a>
                    @else
                        <button type="button" class="currency-language-dialog-trigger v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default" style="width: 55px; cursor: pointer; background-color: rgb(218, 218, 218); padding-left: 5px;">
                            <span class="v-btn__content">
                                <div class="v-avatar language-button" style="height: 25px; min-width: 25px; width: 25px;">
                                    <img src="/static/image/country/BDT.svg" alt="">
                                </div>
                                <i aria-hidden="true" class="v-icon notranslate largerIcon mdi mdi-menu-down theme--light"></i>
                            </span>
                        </button>
                    @endauth
                </div>
                <div class="spacer"></div>
            </div>
            @auth
                <div class="row no-gutters align-center justify-space-between pt-2 pb-2 px-0" style="border-top: 1px solid rgba(0,0,0,0.06);">
                    <div class="col col-auto pr-2" style="min-width: 0;">
                        <div class="color-primary font-weight-bold subtitle-2 text-truncate">{{ auth()->user()->displayUsername() }}</div>
                        <div class="color-base caption">{{ auth()->user()->currencySymbol() }} {{ number_format((float) auth()->user()->balance, 2) }}</div>
                    </div>
                    <div class="col-auto d-flex align-center" style="gap: 6px; flex-shrink: 0;">
                        <button type="button" class="currency-language-dialog-trigger v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default" style="width: 52px; cursor: pointer; background-color: rgb(218, 218, 218); padding-left: 4px;">
                            <span class="v-btn__content">
                                <div class="v-avatar language-button" style="height: 25px; min-width: 25px; width: 25px;">
                                    <img src="/static/image/country/{{ strtoupper(auth()->user()->currency_code ?? 'BDT') }}.svg" alt="">
                                </div>
                                <i aria-hidden="true" class="v-icon notranslate largerIcon mdi mdi-menu-down theme--light"></i>
                            </span>
                        </button>
                        <form action="{{ route('logout') }}" method="post" class="d-inline-block m-0">
                            @csrf
                            <button type="submit" class="v-btn v-btn--icon v-btn--round theme--light v-size--small" title="{{ __('Log out') }}" style="min-width: 40px;">
                                <span class="v-btn__content">
                                    <img src="/static/svg/mobileMenu/logout.svg" alt="" width="22" height="22">
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
