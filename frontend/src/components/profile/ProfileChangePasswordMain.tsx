import { useState } from 'react'

function PasswordHelpIcon() {
  return (
    <span className="depo-help-icon profile-password-help" aria-hidden>
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
      </svg>
    </span>
  )
}

function PasswordFieldInner({
  id,
  label,
  value,
  onChange,
  showHelp,
}: {
  id: string
  label: string
  value: string
  onChange: (v: string) => void
  showHelp?: boolean
}) {
  return (
    <div className="col-md-6 col-lg-4 col">
      <div className="row no-gutters justify-space-between">
        <div className="col col-10">
          <label className="input-field-label ma-0 text-capitalize d-block pb-2 profile-password-float-label" htmlFor={id}>
            {label}
            <span className="red--text ml-1">*</span>
          </label>
        </div>
        {showHelp ? (
          <div className="col col-2 profile-password-help-col">
            <PasswordHelpIcon />
          </div>
        ) : (
          <div className="col col-2" aria-hidden />
        )}
        <div className="col col-12">
          <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined depo-text-field">
            <div className="v-input__control">
              <div className="v-input__slot depo-input-slot">
                <input
                  id={id}
                  autoComplete="new-password"
                  placeholder="এখানে পাসওয়ার্ড পূরণ করুন"
                  type="password"
                  value={value}
                  onChange={(e) => onChange(e.target.value)}
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export function ProfileChangePasswordMain() {
  const [current, setCurrent] = useState('')
  const [next, setNext] = useState('')
  const [confirm, setConfirm] = useState('')

  return (
    <div className="changePassword-wrapper">
      <div className="row hidden-md-and-up password-mobile-header-wrap">
        <div className="password-mobile-header text-center col col-12">পাসওয়ার্ড পরিবর্তন করুন</div>
      </div>

      <div className="v-card v-sheet theme--light desktop_password_card profile-password-card">
        <div className="v-card__title hidden-sm-and-down mx-6 profile-password-card-title">
          <label className="--v-primary-base text-left password-desktop-txt text-capitalize">
            পাসওয়ার্ড পরিবর্তন করুন
          </label>
        </div>
        <div className="profile-detail-card profile-overflow v-card v-sheet theme--light elevation-0">
          <form
            className="v-form profile-password-form"
            noValidate
            onSubmit={(e) => {
              e.preventDefault()
            }}
          >
            <div className="row no-gutters align-end pt-4">
              <PasswordFieldInner
                id="password-current"
                label="বর্তমান গোপন নম্বর"
                value={current}
                onChange={setCurrent}
              />
            </div>
            <div className="row no-gutters align-end">
              <PasswordFieldInner
                id="password-new"
                label="নতুন গোপন নম্বর"
                value={next}
                onChange={setNext}
                showHelp
              />
            </div>
            <div className="row no-gutters align-end">
              <div className="mb-4 col-md-6 col-lg-4 col profile-password-last-col">
                <div className="row no-gutters justify-space-between">
                  <div className="col col-10">
                    <label
                      className="input-field-label ma-0 text-capitalize d-block pb-2 profile-password-float-label"
                      htmlFor="password-confirm"
                    >
                      নিশ্চিত করুন নতুন গোপননম্বর
                      <span className="red--text ml-1">*</span>
                    </label>
                  </div>
                  <div className="col col-2" aria-hidden />
                  <div className="col col-12">
                    <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined depo-text-field">
                      <div className="v-input__control">
                        <div className="v-input__slot depo-input-slot">
                          <input
                            id="password-confirm"
                            autoComplete="new-password"
                            placeholder="এখানে পাসওয়ার্ড পূরণ করুন"
                            type="password"
                            value={confirm}
                            onChange={(e) => setConfirm(e.target.value)}
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button
                  type="submit"
                  className="dialog-button v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default pass-btn-desktop pass-width profile-password-submit"
                >
                  <span className="v-btn__content">জমা দিন</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  )
}
