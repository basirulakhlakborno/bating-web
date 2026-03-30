<div class="col col-12 login_panel auth-panel-outer">
    <div class="row hidden-md-and-up" style="margin: unset;">
        <div class="mobile-header text-center col col-12">
            প্রবেশ করুন BABU88
        </div>
    </div>
    <div class="row hidden-sm-and-down mt-4" style="margin: unset;">
        <div class="login-header text-center py-0 col col-12">
            লগইন করুন
        </div>
        <div class="login-header-desc text-center pt-0 col col-12">
            স্বাগতম!
        </div>
    </div>
    <div class="row justify-center mt-2 mb-6">
        <div class="col-md-4 col-12 login-form-bg pt-0 mb-12">
            <form action="{{ route('login') }}" method="post" novalidate="novalidate" class="v-form login-form-page auth-form-vform">
                @csrf
                <div id="login-ajax-errors" class="auth-ajax-errors red--text subtitle-2 text-center col col-12 py-2" role="alert" hidden style="display: none;"></div>
                <div class="row justify-center">
                    <div class="col col-12">
                        <div>
                            <div class="row no-gutters justify-space-between">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
                                        ব্যবহারকারীর নাম<span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2">
                                    <i aria-hidden="true" class="v-icon notranslate material-icons theme--dark primary--text" style="float: right;">help</i>
                                    <span class="v-tooltip v-tooltip--right"></span>
                                </div>
                                <div class="col col-12">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="username" autocomplete="username" id="login-username" placeholder="এখানে পূরণ করুন" type="text" required>
                                                </div>
                                            </div>
                                            <div class="v-text-field__details">
                                                <div class="v-messages theme--light">
                                                    <div class="v-messages__wrapper"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div>
                            <div class="row no-gutters justify-space-between">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
                                        গোপন নম্বর<span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2">
                                    <i aria-hidden="true" class="v-icon notranslate material-icons theme--dark primary--text" style="float: right;">help</i>
                                    <span class="v-tooltip v-tooltip--right"></span>
                                </div>
                                <div class="col col-12">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="password" autocomplete="current-password" id="login-password" placeholder="এখানে পূরণ করুন" type="password" required>
                                                </div>
                                                <div class="v-input__append-inner">
                                                    <button type="button" class="v-icon notranslate v-icon--link mdi mdi-eye theme--light login-password-toggle" aria-label="Show password"></button>
                                                </div>
                                            </div>
                                            <div class="v-text-field__details">
                                                <div class="v-messages theme--light">
                                                    <div class="v-messages__wrapper"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row hidden-sm-and-down no-gutters">
                            <div class="col col-12">
                                <button type="submit" class="login-submit-btn primary-button desktop-login-btn theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default black" style="height: auto; min-height: 50px;">
                                    <span class="v-btn__content">লগইন করুন</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row hidden-md-and-up no-gutters">
                            <div class="col col-12">
                                <button type="submit" class="login-submit-btn primary-button theme-button text-capitalize pa-2 font-weight-bold yellow--text v-btn v-btn--has-bg theme--light v-size--default black mobile-login-btn" style="height: auto;">
                                    <span class="v-btn__content">লগইন করুন</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row no-gutters login-forgot-row">
                            <div class="col col-12 text-center">
                                <button type="button" class="login-forgot-btn text-capitalize body-3 text-decoration-underline v-btn v-btn--text theme--light v-size--default forgot-text" style="height: auto;">
                                    <span class="v-btn__content">পাসওয়ার্ড ভুলে গেছেন</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row hidden-sm-and-down no-gutters">
                            <div class="col col-12">
                                <p class="input-field-label desktop-register text-center ma-0">
                                    <label>কোনো একাউন্ট এখনও নেই? </label>
                                    <a href="{{ url('/register') }}" class="forgot-text text-decoration-underline">Register here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row no-gutters py-4">
                            <div class="col col-12">
                                <hr role="separator" aria-orientation="horizontal" class="v-divider theme--light dialog-divider-desktop">
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row hidden-md-and-up no-gutters">
                            <div class="col col-12">
                                <label class="input-field-label ma-0 pb-1 d-block title_color2--text">
                                    অ্যাকাউন্ট নেই?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row pb-10 hidden-md-and-up no-gutters">
                            <div class="col col-12">
                                <a href="{{ url('/register') }}" class="auth-to-register-cta full-width font-weight-bold pa-2 dialog-button v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default theme-button subtitle-1 text-decoration-none d-block text-center">
                                    <span class="v-btn__content">সাইন আপ করুন</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="row hidden-sm-and-down px-2 no-gutters">
                            <div class="col col-12">
                                <label class="login-tnc text-center ma-0 pb-1 d-block">
                                    আপনি যদি লগ ইন করতে কোনো সমস্যার সম্মুখীন হন, দয়া করে LiveChat এর মাধ্যমে সহায়তার জন্য আমাদের গ্রাহক পরিষেবার সাথে যোগাযোগ করুন৷
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
