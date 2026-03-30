import { Link } from 'react-router-dom'
import { useCallback, useId, useRef, useState } from 'react'
import { apiUrl } from '../../config/apiBase'

const registerCurrencies = [
  { code: 'BDT', label: '৳ BDT', flag: 'BDT.svg' },
  { code: 'INR', label: '₹ INR', flag: 'INR.svg' },
  { code: 'NPR', label: 'रु NPR', flag: 'NPR.svg' },
  { code: 'PKR', label: '₨ PKR', flag: 'PKR.svg' },
] as const

/** Full `partials/auth/register-panel.blade.php` — POST uses `apiUrl()` from `VITE_API_BASE_URL`. */
export function RegisterPanel() {
  const idPrefix = useId()
  const currencyLabelId = `${idPrefix}-currency-label`
  const pwdRef = useRef<HTMLInputElement>(null)
  const pwd2Ref = useRef<HTMLInputElement>(null)
  const toggle1 = useRef<HTMLButtonElement>(null)
  const toggle2 = useRef<HTMLButtonElement>(null)

  const [currency, setCurrency] = useState<(typeof registerCurrencies)[number]>(registerCurrencies[0])
  const [currencyOpen, setCurrencyOpen] = useState(false)
  const [termsAccepted, setTermsAccepted] = useState(false)
  const [captchaTs, setCaptchaTs] = useState(0)

  const captchaSrc = `${apiUrl('/register/captcha')}${captchaTs ? `?t=${captchaTs}` : ''}`
  const formAction = apiUrl('/register')

  const bindPwToggle = useCallback((input: HTMLInputElement | null, btn: HTMLButtonElement | null) => {
    if (!input || !btn) return
    const show = input.getAttribute('type') === 'password'
    input.setAttribute('type', show ? 'text' : 'password')
    btn.classList.toggle('mdi-eye', !show)
    btn.classList.toggle('mdi-eye-off', show)
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password')
  }, [])

  return (
    <div className="col col-12 auth-panel-outer register_panel">
      <div className="row hidden-md-and-up" style={{ margin: 'unset' }}>
        <div className="mobile-header text-center col col-12">নিবন্ধন করুন</div>
        <div className="pa-0 col col-12">
          <div className="v-image v-responsive theme--light" style={{ minHeight: 120, background: 'linear-gradient(135deg, #e8e8e8 0%, #bdbdbd 100%)' }}>
            <div
              className="v-image__image v-image__image--cover"
              style={{
                backgroundPosition: 'center center',
                backgroundSize: 'cover',
                backgroundImage: "url('/static/image/banner/registerBanner/register_banner_bd.jpg')",
                minHeight: 120,
              }}
            />
            <div className="v-responsive__content"></div>
          </div>
        </div>
      </div>

      <div className="row hidden-sm-and-down mt-2" style={{ margin: 'unset' }}>
        <div className="login-header text-center py-0 col col-12">একাউন্ট তৈরি করুন</div>
        <div className="login-header-desc text-center pt-0 col col-12">
          আসুন আপনাকে No.1 ক্রিকেট এক্সচেঞ্জ এবং বেটিং প্ল্যাটফর্মে নিবন্ধন করিয়ে দিই
        </div>
      </div>

      <div className="row justify-center mt-2 mb-6">
        <div className="col-md-6 col-12 login-form-bg pa-0 mb-12">
          <div className="pa-0 col col-12 hidden-sm-and-down">
            <div className="v-image v-responsive theme--light" style={{ position: 'relative' }}>
              <div className="v-responsive__sizer" style={{ paddingBottom: '25%' }}></div>
              <div
                className="v-image__image v-image__image--cover"
                style={{
                  position: 'absolute',
                  inset: 0,
                  backgroundImage: "url('/static/image/banner/registerBanner/register_banner_bd.jpg')",
                  backgroundPosition: 'center center',
                  backgroundSize: 'cover',
                  backgroundColor: '#333',
                }}
              />
              <div className="v-responsive__content"></div>
            </div>
          </div>

          <form action={formAction} method="post" noValidate className="v-form register-form-page auth-form-vform">
            <input type="hidden" name="_token" value="" />
            <div
              id="register-ajax-errors"
              className="auth-ajax-errors red--text subtitle-2 text-center col col-12 py-2"
              role="alert"
              hidden
              style={{ display: 'none' }}
            />
            <div className="row justify-center">
              <div className="col col-12">
                <div className="v-card__text ma-0 pa-0">
                  <div className="row no-gutters justify-space-between">
                    <div className="col col-10">
                      <label className="input-field-label ma-0 text-capitalize d-block pb-2" style={{ float: 'left' }}>
                        ব্যবহারকারীর নাম<span className="red--text ml-1">*</span>
                      </label>
                    </div>
                    <div className="col col-2">
                      <i aria-hidden="true" className="v-icon notranslate material-icons theme--dark primary--text" style={{ float: 'right' }}>
                        help
                      </i>
                    </div>
                    <div className="col col-12">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input name="username" id="register-username" autoComplete="username" placeholder="এখানে পূরণ করুন" type="text" required />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <div className="v-card__text ma-0 pa-0">
                  <div className="row no-gutters justify-space-between">
                    <div className="col col-10">
                      <label className="input-field-label ma-0 text-capitalize d-block pb-2" style={{ float: 'left' }} htmlFor="register-password">
                        পাসওয়ার্ড <span className="body-2 font-weight-regular" lang="bn">
                          (গোপন নম্বর)
                        </span>
                        <span className="red--text ml-1">*</span>
                      </label>
                    </div>
                    <div className="col col-2">
                      <i aria-hidden="true" className="v-icon notranslate material-icons theme--dark primary--text" style={{ float: 'right' }}>
                        help
                      </i>
                    </div>
                    <div className="col col-12">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input
                                ref={pwdRef}
                                name="password"
                                id="register-password"
                                type="password"
                                autoComplete="new-password"
                                placeholder="এখানে পাসওয়ার্ড পূরণ করুন"
                                minLength={6}
                                maxLength={255}
                                spellCheck={false}
                                autoCapitalize="off"
                                required
                              />
                            </div>
                            <div className="v-input__append-inner">
                              <button
                                ref={toggle1}
                                type="button"
                                className="v-icon notranslate v-icon--link mdi mdi-eye theme--light"
                                aria-label="Show password"
                                onClick={() => bindPwToggle(pwdRef.current, toggle1.current)}
                              />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <div className="v-card__text ma-0 pa-0">
                  <div className="row no-gutters justify-space-between">
                    <div className="col col-10">
                      <label className="input-field-label ma-0 text-capitalize d-block pb-2" style={{ float: 'left' }} htmlFor="register-password-confirm">
                        পাসওয়ার্ড নিশ্চিত করুন<span className="red--text ml-1">*</span>
                      </label>
                    </div>
                    <div className="col col-2"></div>
                    <div className="col col-12">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input
                                ref={pwd2Ref}
                                name="password_confirmation"
                                id="register-password-confirm"
                                type="password"
                                autoComplete="new-password"
                                placeholder="পাসওয়ার্ড নিশ্চিত করুন"
                                minLength={6}
                                maxLength={255}
                                spellCheck={false}
                                autoCapitalize="off"
                                required
                              />
                            </div>
                            <div className="v-input__append-inner">
                              <button
                                ref={toggle2}
                                type="button"
                                className="v-icon notranslate v-icon--link mdi mdi-eye theme--light"
                                aria-label="Show password"
                                onClick={() => bindPwToggle(pwd2Ref.current, toggle2.current)}
                              />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <div className="v-card__text ma-0 pa-0">
                  <label className="input-field-label ma-0 pb-1 text-capitalize d-block" id={currencyLabelId}>
                    মুদ্রা<span className="red--text ml-1">*</span>
                  </label>
                  <div className="register-currency-field" data-register-currency>
                    <input type="hidden" name="currency" value={currency.code} required className="register-currency-hidden" id="register-currency-value" />
                    <div className="v-input v-input--is-label-active v-input--is-dirty v-input--dense theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined register-currency-vinput">
                      <div className="v-input__control">
                        <div
                          role="button"
                          tabIndex={0}
                          aria-haspopup="listbox"
                          aria-expanded={currencyOpen}
                          aria-labelledby={currencyLabelId}
                          className="v-input__slot register-currency-trigger"
                          onClick={() => setCurrencyOpen((o) => !o)}
                          onKeyDown={(e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                              e.preventDefault()
                              setCurrencyOpen((o) => !o)
                            }
                          }}
                        >
                          <fieldset aria-hidden="true">
                            <legend style={{ width: 0 }}>
                              <span className="notranslate">​</span>
                            </legend>
                          </fieldset>
                          <div className="register-currency-selections d-flex align-center flex-grow-1">
                            <div className="v-avatar language-button register-currency-trigger-avatar" style={{ height: 36, minWidth: 36, width: 36 }}>
                              <img src={`/static/image/country/${currency.flag}`} alt="" className="register-currency-trigger-flag" width={36} height={36} />
                            </div>
                            <span className="ml-2 register-currency-trigger-text">{currency.label}</span>
                          </div>
                          <div className="v-input__append-inner">
                            <div className="v-input__icon v-input__icon--append">
                              <i aria-hidden="true" className="v-icon notranslate mdi mdi-menu-down theme--light"></i>
                            </div>
                          </div>
                        </div>
                        <div className="v-text-field__details">
                          <div className="v-messages theme--light">
                            <div className="v-messages__wrapper"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="register-currency-dropdown v-sheet theme--light elevation-3" data-register-currency-menu hidden={!currencyOpen} role="listbox">
                      {registerCurrencies.map((c) => {
                        const flagUrl = `/static/image/country/${c.flag}`
                        return (
                          <button
                            key={c.code}
                            type="button"
                            role="option"
                            className="register-currency-option"
                            data-currency-code={c.code}
                            data-currency-label={c.label}
                            data-currency-flag={flagUrl}
                            onClick={() => {
                              setCurrency(c)
                              setCurrencyOpen(false)
                            }}
                          >
                            <span className="v-avatar language-button register-currency-option-avatar">
                              <img src={flagUrl} alt="" width={40} height={40} />
                            </span>
                            <span className="register-currency-option-label">{c.label}</span>
                          </button>
                        )
                      })}
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <div className="v-card__text ma-0 pa-0">
                  <label className="input-field-label ma-0 text-capitalize d-block pb-2">মোবাইল নম্বর<span className="red--text ml-1">*</span></label>
                  <div className="row no-gutters">
                    <div className="col-4 col-md-3">
                      <div className="mr-2 reg-desktop-prefix">
                        <div className="v-input input-field elevation-0 hide-details v-input--is-disabled v-input--is-readonly theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                          <div className="v-input__control">
                            <div className="v-input__slot">
                              <fieldset aria-hidden="true">
                                <legend style={{ width: 0 }}>
                                  <span className="notranslate">​</span>
                                </legend>
                              </fieldset>
                              <div className="v-text-field__slot">
                                <input type="text" value="+880" disabled readOnly id="register-phone-prefix" aria-hidden />
                              </div>
                            </div>
                            <div className="v-text-field__details">
                              <div className="v-messages theme--light">
                                <div className="v-messages__wrapper"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="col-8 col-md-9">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input name="phone" id="register-phone" autoComplete="tel" placeholder="এখানে পূরণ করুন" type="text" required />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <div className="register-captcha">
                  <label className="input-field-label ma-0 text-capitalize d-block pb-2" htmlFor="register-captcha-input">
                    ভেরিফিকেশন কোড<span className="red--text ml-1">*</span>
                  </label>
                  <div className="register-captcha-inner">
                    <div className="register-captcha-field">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input name="captcha" id="register-captcha-input" autoComplete="off" type="text" required />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div className="register-captcha-side">
                      <div className="register-captcha-img-wrap">
                        <img id="register-captcha-img" className="register-captcha-img" src={captchaSrc} alt="" decoding="async" />
                      </div>
                      <button
                        type="button"
                        className="refresh register-captcha-refresh v-btn v-btn--icon theme--light"
                        id="register-captcha-refresh"
                        title="নতুন কোড"
                        onClick={() => setCaptchaTs(Date.now())}
                      >
                        <span className="v-btn__content">
                          <i aria-hidden="true" className="v-icon notranslate mdi mdi-refresh theme--light"></i>
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div className="col col-12">
                <hr role="separator" aria-orientation="horizontal" className="v-divider theme--light" />
              </div>

              <div className="col col-12">
                <details className="register-referral-details">
                  <summary className="register-referral-summary input-field-label ma-0 d-flex align-center justify-space-between">
                    <span>রেফারেল কোড</span>
                    <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-down theme--light register-referral-chevron"></i>
                  </summary>
                  <div className="register-referral-panel">
                    <div className="register-referral-panel-inner pt-2 pb-2">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--is-booted v-text-field--enclosed v-text-field--outlined v-text-field--placeholder">
                        <div className="v-input__control">
                          <div className="v-input__slot">
                            <fieldset aria-hidden="true">
                              <legend style={{ width: 0 }}>
                                <span className="notranslate">​</span>
                              </legend>
                            </fieldset>
                            <div className="v-text-field__slot">
                              <input name="referral" id="register-referral" placeholder="(চ্ছিক)" type="text" />
                            </div>
                          </div>
                          <div className="v-text-field__details">
                            <div className="v-messages theme--light">
                              <div className="v-messages__wrapper"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </details>
              </div>

              <div className="col col-12">
                <div className="row hidden-sm-and-down no-gutters">
                  <div className="col col-12">
                    <button
                      type="submit"
                      className="register-submit-btn primary-button desktop-login-btn theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default"
                      style={{ height: 'auto', minHeight: 50 }}
                    >
                      <span className="v-btn__content">নিবন্ধন</span>
                    </button>
                  </div>
                </div>
                <div className="row hidden-md-and-up no-gutters">
                  <div className="col col-12">
                    <button
                      type="submit"
                      className="register-submit-btn primary-button theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default mobile-login-btn"
                      style={{ height: 'auto' }}
                    >
                      <span className="v-btn__content">নিবন্ধন</span>
                    </button>
                  </div>
                </div>
              </div>

              <div className="col col-12 register-terms-col">
                <div className="v-input mt-3 pt-0 mb-0 theme--light v-input--selection-controls v-input--checkbox">
                  <div className="v-input__control">
                    <label className="v-input__slot register-terms-label d-flex align-start flex-nowrap">
                      <div className="v-input--selection-controls__input flex-shrink-0 mr-2 mt-1">
                        <i
                          aria-hidden="true"
                          className={`v-icon notranslate theme--light register-terms-checkbox-icon mdi ${
                            termsAccepted ? 'mdi-checkbox-marked' : 'mdi-checkbox-blank-outline'
                          }`}
                        ></i>
                        <input
                          name="terms_accepted"
                          id="register-terms"
                          className="register-terms-checkbox-input"
                          type="checkbox"
                          value="1"
                          required
                          autoComplete="off"
                          checked={termsAccepted}
                          onChange={(e) => setTermsAccepted(e.target.checked)}
                        />
                        <div className="v-input--selection-controls__ripple"></div>
                      </div>
                      <span className="v-label theme--light flex-grow-1 pb-0" style={{ left: 0, right: 'auto', position: 'relative' }}>
                        <p className="pt-0 mb-0 disclaim-txt">
                          <span>
                            রেজিস্টার বোতামে ক্লিক করে, আমি এতদ্বারা স্বীকার করছি যে আমার বয়স 18 বছরের বেশি এবং আমি আপনার শর্তাবলী পড়েছি এবং মেনে নিয়েছি।
                          </span>
                        </p>
                      </span>
                    </label>
                  </div>
                </div>
              </div>

              <div className="col col-12 py-4">
                <p className="text-center ma-0">
                  <Link to="/login" className="forgot-text text-decoration-underline">
                    ইতিমধ্যে একাউন্ট আছে? লগইন
                  </Link>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  )
}
