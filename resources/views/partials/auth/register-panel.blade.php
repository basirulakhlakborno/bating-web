<div class="col col-12 auth-panel-outer register_panel">
    <div class="row hidden-md-and-up" style="margin: unset;">
        <div class="mobile-header text-center col col-12">
            নিবন্ধন করুন
        </div>
        <div class="pa-0 col col-12">
            <div class="v-image v-responsive theme--light" style="min-height: 120px; background: linear-gradient(135deg, #e8e8e8 0%, #bdbdbd 100%);">
                <div class="v-image__image v-image__image--cover" style="background-position: center center; background-size: cover; background-image: url('/static/image/banner/registerBanner/register_banner_bd.jpg'); min-height: 120px;"></div>
                <div class="v-responsive__content"></div>
            </div>
        </div>
    </div>

    <div class="row hidden-sm-and-down mt-2" style="margin: unset;">
        <div class="login-header text-center py-0 col col-12">
            একাউন্ট তৈরি করুন
        </div>
        <div class="login-header-desc text-center pt-0 col col-12">
            আসুন আপনাকে No.1 ক্রিকেট এক্সচেঞ্জ এবং বেটিং প্ল্যাটফর্মে নিবন্ধন করিয়ে দিই
        </div>
    </div>

    <div class="row justify-center mt-2 mb-6">
        <div class="col-md-6 col-12 login-form-bg pa-0 mb-12">
            <div class="pa-0 col col-12 hidden-sm-and-down">
                <div class="v-image v-responsive theme--light" style="position: relative;">
                    <div class="v-responsive__sizer" style="padding-bottom: 25%;"></div>
                    <div class="v-image__image v-image__image--cover" style="position: absolute; inset: 0; background-image: url('/static/image/banner/registerBanner/register_banner_bd.jpg'); background-position: center center; background-size: cover; background-color: #333;"></div>
                    <div class="v-responsive__content"></div>
                </div>
            </div>

            <form action="{{ route('register') }}" method="post" novalidate="novalidate" class="v-form register-form-page auth-form-vform">
                @csrf
                <div id="register-ajax-errors" class="auth-ajax-errors red--text subtitle-2 text-center col col-12 py-2" role="alert" hidden style="display: none;"></div>
                <div class="row justify-center">
                    <div class="col col-12">
                        <div class="v-card__text ma-0 pa-0">
                            <div class="row no-gutters justify-space-between">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
                                        ব্যবহারকারীর নাম<span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2">
                                    <i aria-hidden="true" class="v-icon notranslate material-icons theme--dark primary--text" style="float: right;">help</i>
                                </div>
                                <div class="col col-12">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="username" id="register-username" autocomplete="username" placeholder="এখানে পূরণ করুন" type="text" required>
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
                        <div class="v-card__text ma-0 pa-0">
                            <div class="row no-gutters justify-space-between">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;" for="register-password">
                                        পাসওয়ার্ড <span class="body-2 font-weight-regular" lang="bn">(গোপন নম্বর)</span><span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2">
                                    <i aria-hidden="true" class="v-icon notranslate material-icons theme--dark primary--text" style="float: right;">help</i>
                                </div>
                                <div class="col col-12">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="password" id="register-password" type="password" autocomplete="new-password" placeholder="এখানে পাসওয়ার্ড পূরণ করুন" minlength="6" maxlength="255" spellcheck="false" autocapitalize="off" required>
                                                </div>
                                                <div class="v-input__append-inner">
                                                    <button type="button" class="v-icon notranslate v-icon--link mdi mdi-eye theme--light" data-register-pw-toggle="reg-pass" aria-label="Show password"></button>
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
                        <div class="v-card__text ma-0 pa-0">
                            <div class="row no-gutters justify-space-between">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;" for="register-password-confirm">
                                        পাসওয়ার্ড নিশ্চিত করুন<span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2"></div>
                                <div class="col col-12">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="password_confirmation" id="register-password-confirm" type="password" autocomplete="new-password" placeholder="পাসওয়ার্ড নিশ্চিত করুন" minlength="6" maxlength="255" spellcheck="false" autocapitalize="off" required>
                                                </div>
                                                <div class="v-input__append-inner">
                                                    <button type="button" class="v-icon notranslate v-icon--link mdi mdi-eye theme--light" data-register-pw-toggle="reg-pass2" aria-label="Show password"></button>
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

                    @php
                        $registerCurrencies = [
                            ['code' => 'BDT', 'label' => '৳ BDT', 'flag' => 'BDT.svg'],
                            ['code' => 'INR', 'label' => '₹ INR', 'flag' => 'INR.svg'],
                            ['code' => 'NPR', 'label' => 'रु NPR', 'flag' => 'NPR.svg'],
                            ['code' => 'PKR', 'label' => '₨ PKR', 'flag' => 'PKR.svg'],
                        ];
                    @endphp
                    <div class="col col-12">
                        <div class="v-card__text ma-0 pa-0">
                            <label class="input-field-label ma-0 pb-1 text-capitalize d-block" id="register-currency-label">
                                মুদ্রা<span class="red--text ml-1">*</span>
                            </label>
                            <div class="register-currency-field" data-register-currency>
                                <input type="hidden" name="currency" value="BDT" required class="register-currency-hidden" id="register-currency-value">
                                <div class="v-input v-input--is-label-active v-input--is-dirty v-input--dense theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined register-currency-vinput">
                                    <div class="v-input__control">
                                        <div role="button" tabindex="0" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="register-currency-label" class="v-input__slot register-currency-trigger">
                                            <fieldset aria-hidden="true">
                                                <legend style="width: 0;"><span class="notranslate">​</span></legend>
                                            </fieldset>
                                            <div class="register-currency-selections d-flex align-center flex-grow-1">
                                                <div class="v-avatar language-button register-currency-trigger-avatar" style="height: 36px; min-width: 36px; width: 36px;">
                                                    <img src="/static/image/country/BDT.svg" alt="" class="register-currency-trigger-flag" width="36" height="36">
                                                </div>
                                                <span class="ml-2 register-currency-trigger-text">৳ BDT</span>
                                            </div>
                                            <div class="v-input__append-inner">
                                                <div class="v-input__icon v-input__icon--append">
                                                    <i aria-hidden="true" class="v-icon notranslate mdi mdi-menu-down theme--light"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="v-text-field__details">
                                            <div class="v-messages theme--light">
                                                <div class="v-messages__wrapper"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="register-currency-dropdown v-sheet theme--light elevation-3" data-register-currency-menu hidden role="listbox">
                                    @foreach ($registerCurrencies as $c)
                                        @php $flagUrl = '/static/image/country/' . $c['flag']; @endphp
                                        <button type="button" role="option" class="register-currency-option"
                                            data-currency-code="{{ $c['code'] }}"
                                            data-currency-label="{{ $c['label'] }}"
                                            data-currency-flag="{{ $flagUrl }}">
                                            <span class="v-avatar language-button register-currency-option-avatar">
                                                <img src="{{ $flagUrl }}" alt="" width="40" height="40">
                                            </span>
                                            <span class="register-currency-option-label">{{ $c['label'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12">
                        <div class="v-card__text ma-0 pa-0">
                            <label class="input-field-label ma-0 text-capitalize d-block pb-2">
                                মোবাইল নম্বর<span class="red--text ml-1">*</span>
                            </label>
                            <div class="row no-gutters">
                                <div class="col-4 col-md-3">
                                    <div class="mr-2 reg-desktop-prefix">
                                        <div class="v-input input-field elevation-0 hide-details v-input--is-disabled v-input--is-readonly theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                            <div class="v-input__control">
                                                <div class="v-input__slot">
                                                    <fieldset aria-hidden="true">
                                                        <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                    </fieldset>
                                                    <div class="v-text-field__slot">
                                                        <input type="text" value="+880" disabled readonly id="register-phone-prefix" aria-hidden="true">
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
                                <div class="col-8 col-md-9">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="phone" id="register-phone" autocomplete="tel" placeholder="এখানে পূরণ করুন" type="text" required>
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
                        <div class="register-captcha">
                            <label class="input-field-label ma-0 text-capitalize d-block pb-2" for="register-captcha-input">
                                ভেরিফিকেশন কোড<span class="red--text ml-1">*</span>
                            </label>
                            <div class="register-captcha-inner">
                                <div class="register-captcha-field">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="captcha" id="register-captcha-input" autocomplete="off" type="text" required>
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
                                <div class="register-captcha-side">
                                    <div class="register-captcha-img-wrap">
                                        <img id="register-captcha-img" class="register-captcha-img" src="{{ route('register.captcha') }}" alt="" decoding="async" data-captcha-url="{{ route('register.captcha') }}">
                                    </div>
                                    <button type="button" class="refresh register-captcha-refresh v-btn v-btn--icon theme--light" id="register-captcha-refresh" title="নতুন কোড">
                                        <span class="v-btn__content">
                                            <i aria-hidden="true" class="v-icon notranslate mdi mdi-refresh theme--light"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12">
                        <hr role="separator" aria-orientation="horizontal" class="v-divider theme--light">
                    </div>

                    <div class="col col-12">
                        <details class="register-referral-details">
                            <summary class="register-referral-summary input-field-label ma-0 d-flex align-center justify-space-between">
                                <span>রেফারেল কোড</span>
                                <i aria-hidden="true" class="v-icon notranslate mdi mdi-chevron-down theme--light register-referral-chevron"></i>
                            </summary>
                            <div class="register-referral-panel">
                                <div class="register-referral-panel-inner pt-2 pb-2">
                                    <div class="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                                        <div class="v-input__control">
                                            <div class="v-input__slot">
                                                <fieldset aria-hidden="true">
                                                    <legend style="width: 0px;"><span class="notranslate">​</span></legend>
                                                </fieldset>
                                                <div class="v-text-field__slot">
                                                    <input name="referral" id="register-referral" placeholder="(চ্ছিক)" type="text">
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
                        </details>
                    </div>

                    <div class="col col-12">
                        <div class="row hidden-sm-and-down no-gutters">
                            <div class="col col-12">
                                <button type="submit" class="register-submit-btn primary-button desktop-login-btn theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default" style="height: auto; min-height: 50px;">
                                    <span class="v-btn__content">নিবন্ধন</span>
                                </button>
                            </div>
                        </div>
                        <div class="row hidden-md-and-up no-gutters">
                            <div class="col col-12">
                                <button type="submit" class="register-submit-btn primary-button theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default mobile-login-btn" style="height: auto;">
                                    <span class="v-btn__content">নিবন্ধন</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12 register-terms-col">
                        <div class="v-input mt-3 pt-0 mb-0 theme--light v-input--selection-controls v-input--checkbox">
                            <div class="v-input__control">
                                <label class="v-input__slot register-terms-label d-flex align-start flex-nowrap">
                                    <div class="v-input--selection-controls__input flex-shrink-0 mr-2 mt-1">
                                        <i aria-hidden="true" class="v-icon notranslate mdi mdi-checkbox-blank-outline theme--light register-terms-checkbox-icon"></i>
                                        <input name="terms_accepted" id="register-terms" class="register-terms-checkbox-input" type="checkbox" value="1" required autocomplete="off">
                                        <div class="v-input--selection-controls__ripple"></div>
                                    </div>
                                    <span class="v-label theme--light flex-grow-1 pb-0" style="left: 0; right: auto; position: relative;">
                                        <p class="pt-0 mb-0 disclaim-txt">
                                            <span>রেজিস্টার বোতামে ক্লিক করে, আমি এতদ্বারা স্বীকার করছি যে আমার বয়স 18 বছরের বেশি এবং আমি আপনার শর্তাবলী পড়েছি এবং মেনে নিয়েছি।</span>
                                        </p>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
