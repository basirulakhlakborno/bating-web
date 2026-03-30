<aside class="mobile-navigation-drawer v-navigation-drawer v-navigation-drawer--absolute v-navigation-drawer--close v-navigation-drawer--is-mobile v-navigation-drawer--temporary theme--light" left="" style="height: 100%; top: 0px; transform: translateX(-100%); width: 256px;">
    <div class="v-navigation-drawer__content">
        <div class="row">
            <div class="mobile-drawer-menu-header-section col col-12">
                <a href="/" class="mobile-drawer-menu-logo router-link-exact-active router-link-active">
                    <img src="/static/svg/babu88_logo_black.svg" alt="" width="180" height="30" class="mt-4">
                </a>
                <button type="button" class="v-icon notranslate mobile-drawer-menu-icon v-icon--link mdi mdi-menu theme--light">
                </button>
            </div>
        </div>
        <hr role="separator" aria-orientation="horizontal" class="my-4 mx-4 v-divider theme--light">
        <div role="list" class="v-list pb-16 mobileMenuListItem v-sheet theme--light v-list--dense v-list--nav">
            <div role="listbox" class="v-item-group theme--light v-list-item-group">
                @foreach ($layoutDrawerTop ?? [] as $item)
                    @include('components.partials.drawer-nav-row', ['item' => $item])
                @endforeach
            </div>
            <hr role="separator" aria-orientation="horizontal" class="my-4 mx-4 v-divider theme--light">
            <span class="mobile-drawer-itemgroup-title">Games</span>
            <div role="listbox" class="v-item-group theme--light v-list-item-group">
                @foreach ($layoutDrawerGames ?? [] as $item)
                    @include('components.partials.drawer-nav-row', ['item' => $item])
                @endforeach
            </div>
            <hr role="separator" aria-orientation="horizontal" class="my-4 mx-4 v-divider theme--light">
            <span class="mobile-drawer-itemgroup-title">Others</span>
            <div role="listbox" class="v-item-group theme--light v-list-item-group">
                <div tabindex="0" role="option" aria-selected="false" class="v-list-item v-list-item--link theme--light">
                    <div class="v-list-item__icon">
                        <button type="button" class="v-btn v-btn--icon v-btn--round theme--light v-size--small" style="margin-left: -3px;">
                            <span class="v-btn__content">
                                <div class="v-avatar language-button" style="height: 25px; min-width: 25px; width: 25px;">
                                    <img src="/static/svg/mobileMenu/icon_language.svg" alt="">
                                </div>
                            </span>
                        </button>
                    </div>
                    <div class="v-list-item__content">
                        <div class="v-list-item__title">
                            ভাষা
                        </div>
                    </div>
                </div>
                @foreach ($layoutDrawerOthers ?? [] as $item)
                    @include('components.partials.drawer-nav-row', ['item' => $item])
                @endforeach
                <div tabindex="0" role="option" aria-selected="false" class="v-list-item v-list-item--link theme--light">
                    <div class="v-list-item__icon">
                        <button type="button" class="v-btn v-btn--icon v-btn--round theme--light v-size--small" style="margin-left: -3px;">
                            <span class="v-btn__content">
                                <div class="v-avatar" style="height: 25px; min-width: 25px; width: 25px;">
                                    <img src="/static/svg/mobileMenu/liveChat.svg" alt="">
                                </div>
                            </span>
                        </button>
                    </div>
                    <div class="v-list-item__content">
                        <div class="v-list-item__title">
                            সরাসরি কথোপকথন
                        </div>
                    </div>
                </div>
                <div tabindex="0" role="option" aria-selected="false" class="v-list-item v-list-item--link theme--light">
                    <div class="v-list-item__icon">
                        <button type="button" class="v-btn v-btn--icon v-btn--round theme--light v-size--small" style="margin-left: -3px;">
                            <span class="v-btn__content">
                                <div class="v-avatar" style="height: 25px; min-width: 25px; width: 25px;">
                                    <img src="/static/svg/mobileMenu/icon_downloadapp.svg" alt="">
                                </div>
                            </span>
                        </button>
                    </div>
                    <div class="v-list-item__content">
                        <div class="v-list-item__title">
                            ডাউনলোড করুন
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="v-navigation-drawer__border">
    </div>
</aside>
