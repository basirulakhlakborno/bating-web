<div class="col col-12 px-5 register_panel">
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

            <form action="#" method="post" novalidate="novalidate" class="v-form ma-8 register-form-page">
                @csrf
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
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
                                        গোপন নম্বর<span class="red--text ml-1">*</span>
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
                                                    <input name="password" id="register-password" autocomplete="new-password" placeholder="এখানে পাসওয়ার্ড পূরণ করুন" type="password" required>
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
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
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
                                                    <input name="password_confirmation" id="register-password-confirm" autocomplete="new-password" placeholder="পাসওয়ার্ড নিশ্চিত করুন" type="password" required>
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

                    <div class="col col-12 pa-0 col-md-10">
                        <div class="v-card__text ma-0 pa-0">
                            <label class="input-field-label ma-0 pb-1 text-capitalize d-block">
                                মুদ্রা<span class="red--text ml-1">*</span>
                            </label>
                            <select name="currency" id="register-currency" class="register-currency-select" required>
                                <option value="BDT" selected>BDT</option>
                            </select>
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
                            <div class="row no-gutters justify-space-between align-center">
                                <div class="col col-10">
                                    <label class="input-field-label ma-0 text-capitalize d-block pb-2" style="float: left;">
                                        ভেরিফিকেশন কোড<span class="red--text ml-1">*</span>
                                    </label>
                                </div>
                                <div class="col col-2"></div>
                                <div class="col-7 col-md-8">
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
                                <div class="col-5 col-md-4 captcha-code text-right pl-2">
                                    <div class="captcha-code-wrapper captcha d-inline-block align-middle">
                                        <canvas id="register-captcha-canvas" width="68" height="40" class="register-captcha-canvas"></canvas>
                                    </div>
                                    <a href="#" class="refresh d-inline-block align-middle ml-1" id="register-captcha-refresh" title="Refresh">
                                        <i aria-hidden="true" class="v-icon notranslate mdi mdi-refresh theme--light"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12">
                        <hr role="separator" aria-orientation="horizontal" class="v-divider theme--light">
                    </div>

                    <div class="col col-12">
                        <details class="register-referral-details">
                            <summary class="input-field-label ma-0">রেফারেল কোড</summary>
                            <div class="pt-2 pb-2">
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
                        </details>
                    </div>

                    <div class="col col-12">
                        <div class="v-input mt-2 pt-0 theme--light v-input--selection-controls v-input--checkbox">
                            <div class="v-input__control">
                                <div class="v-input__slot">
                                    <div class="v-input--selection-controls__input">
                                        <i aria-hidden="true" class="v-icon notranslate mdi mdi-checkbox-blank-outline theme--light"></i>
                                        <input name="terms_accepted" id="register-terms" role="checkbox" type="checkbox" value="1" required>
                                        <div class="v-input--selection-controls__ripple"></div>
                                    </div>
                                    <label for="register-terms" class="v-label theme--light" style="left: 0; right: auto; position: relative;">
                                        <p class="pt-2 mb-0 disclaim-txt">
                                            <span>রেজিস্টার বোতামে ক্লিক করে, আমি এতদ্বারা স্বীকার করছি যে আমার বয়স 18 বছরের বেশি এবং আমি আপনার শর্তাবলী পড়েছি এবং মেনে নিয়েছি।</span>
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12">
                        <div class="text-center col col-12 pt-2">
                            <label class="red--text subtitle-2" style="display: none;"></label>
                        </div>
                    </div>

                    <div class="col col-12">
                        <button type="submit" class="register-submit-btn primary-button theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default black" style="height: auto;">
                            <span class="v-btn__content">নিবন্ধন</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
