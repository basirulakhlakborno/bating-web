import { Link } from 'react-router-dom'
import { useCallback, useRef } from 'react'
import { apiUrl } from '../../config/apiBase'
import { submitLoginAjax } from '../../lib/authFormFetch'

/** Guest login: always JSON `fetch` to Laravel (`expectsJson`), never a document navigation. */
export function LoginPanel() {
  const formRef = useRef<HTMLFormElement>(null)
  const userRef = useRef<HTMLInputElement>(null)
  const pwdRef = useRef<HTMLInputElement>(null)
  const toggleRef = useRef<HTMLButtonElement>(null)

  const onTogglePwd = useCallback(() => {
    const pwd = pwdRef.current
    const toggle = toggleRef.current
    if (!pwd || !toggle) return
    const show = pwd.getAttribute('type') === 'password'
    pwd.setAttribute('type', show ? 'text' : 'password')
    toggle.classList.toggle('mdi-eye', !show)
    toggle.classList.toggle('mdi-eye-off', show)
    toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password')
  }, [])

  const onLoginSubmit = useCallback((e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    e.stopPropagation()
    const username = userRef.current?.value?.trim() ?? ''
    const password = pwdRef.current?.value ?? ''
    void submitLoginAjax({
      url: apiUrl('/api/login'),
      username,
      password,
      errorId: 'login-ajax-errors',
      successMessage: 'সফলভাবে লগইন হয়েছে।',
      formForBusy: formRef.current,
    })
  }, [])

  return (
    <div className="col col-12 login_panel auth-panel-outer">
      <div className="row hidden-sm-and-down mt-4" style={{ margin: 'unset' }}>
        <div className="login-header text-center py-0 col col-12">লগইন করুন</div>
        <div className="login-header-desc text-center pt-0 col col-12">স্বাগতম!</div>
      </div>
      <div className="row justify-center mt-2 mb-6">
        <div className="col-md-4 col-12 login-form-bg pt-0 mb-12">
          <form
            ref={formRef}
            action="#"
            method="post"
            noValidate
            className="v-form login-form-page auth-form-vform"
            onSubmit={onLoginSubmit}
          >
            <div
              id="login-ajax-errors"
              className="auth-ajax-errors red--text subtitle-2 text-center col col-12 py-2"
              role="alert"
              hidden
              style={{ display: 'none' }}
            />
            <div className="row justify-center">
              <div className="col col-12">
                <div>
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
                      <span className="v-tooltip v-tooltip--right"></span>
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
                                ref={userRef}
                                name="username"
                                autoComplete="username"
                                id="login-username"
                                placeholder="এখানে পূরণ করুন"
                                type="text"
                                required
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
                <div>
                  <div className="row no-gutters justify-space-between">
                    <div className="col col-10">
                      <label className="input-field-label ma-0 text-capitalize d-block pb-2" style={{ float: 'left' }}>
                        গোপন নম্বর<span className="red--text ml-1">*</span>
                      </label>
                    </div>
                    <div className="col col-2">
                      <i aria-hidden="true" className="v-icon notranslate material-icons theme--dark primary--text" style={{ float: 'right' }}>
                        help
                      </i>
                      <span className="v-tooltip v-tooltip--right"></span>
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
                                autoComplete="current-password"
                                id="login-password"
                                placeholder="এখানে পূরণ করুন"
                                type="password"
                                required
                              />
                            </div>
                            <div className="v-input__append-inner">
                              <button
                                ref={toggleRef}
                                type="button"
                                className="v-icon notranslate v-icon--link mdi mdi-eye theme--light login-password-toggle"
                                aria-label="Show password"
                                onClick={onTogglePwd}
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
                <div className="row hidden-sm-and-down no-gutters">
                  <div className="col col-12">
                    <button
                      type="submit"
                      className="login-submit-btn primary-button desktop-login-btn theme-button text-capitalize pa-2 v-btn v-btn--has-bg theme--light v-size--default black"
                      style={{ height: 'auto', minHeight: 50 }}
                    >
                      <span className="v-btn__content">লগইন করুন</span>
                    </button>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row hidden-md-and-up no-gutters">
                  <div className="col col-12">
                    <button
                      type="submit"
                      className="login-submit-btn primary-button theme-button text-capitalize pa-2 font-weight-bold yellow--text v-btn v-btn--has-bg theme--light v-size--default black mobile-login-btn"
                      style={{ height: 'auto' }}
                    >
                      <span className="v-btn__content">লগইন করুন</span>
                    </button>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row no-gutters login-forgot-row">
                  <div className="col col-12 text-center">
                    <button
                      type="button"
                      className="login-forgot-btn text-capitalize body-3 text-decoration-underline v-btn v-btn--text theme--light v-size--default forgot-text"
                      style={{ height: 'auto' }}
                    >
                      <span className="v-btn__content">পাসওয়ার্ড ভুলে গেছেন</span>
                    </button>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row hidden-sm-and-down no-gutters">
                  <div className="col col-12">
                    <p className="input-field-label desktop-register text-center ma-0">
                      <label>কোনো একাউন্ট এখনও নেই? </label>
                      <Link to="/register" className="forgot-text text-decoration-underline">
                        Register here
                      </Link>
                    </p>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row no-gutters py-4">
                  <div className="col col-12">
                    <hr role="separator" aria-orientation="horizontal" className="v-divider theme--light dialog-divider-desktop" />
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row hidden-md-and-up no-gutters">
                  <div className="col col-12">
                    <label className="input-field-label ma-0 pb-1 d-block title_color2--text">অ্যাকাউন্ট নেই?</label>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row pb-10 hidden-md-and-up no-gutters">
                  <div className="col col-12">
                    <Link
                      to="/register"
                      className="auth-to-register-cta full-width font-weight-bold pa-2 dialog-button v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default theme-button subtitle-1 text-decoration-none d-block text-center"
                    >
                      <span className="v-btn__content">সাইন আপ করুন</span>
                    </Link>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row hidden-sm-and-down px-2 no-gutters">
                  <div className="col col-12">
                    <label className="login-tnc text-center ma-0 pb-1 d-block">
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
  )
}
