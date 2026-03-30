import { Link } from 'react-router-dom'

type Props = {
  onCurrencyClick: () => void
}

/** Guest actions from `desktop-header.blade.php` (@else branch). */
export function DesktopHeader({ onCurrencyClick }: Props) {
  return (
    <div className="row hidden-sm-and-down header-top no-gutters align-center justify-space-between">
      <div className="header-column col col-5">
        <Link to="/" className="router-link-active">
          <img
            src="/static/svg/bb88_logo_animation2.gif"
            alt=""
            width={312}
            height={58}
            style={{ float: 'left' }}
          />
        </Link>
      </div>
      <div className="header-column register-dialog text-right col-md-6 col-lg-5 col-5">
        <div className="row no-gutters justify-end">
          <div className="text-right hidden-sm-and-down col col-12">
            <Link
              to="/login"
              className="mr-6 embedded-login-button pa-2 font-weight-bold black--text subtitle-1 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none"
              style={{
                height: 'auto',
                backgroundColor: 'rgb(255, 206, 1)',
                borderColor: 'rgb(255, 206, 1)',
                borderRadius: 8,
                fontSize: '14px !important',
              }}
            >
              <span className="v-btn__content">লগইন করুন</span>
            </Link>
            <Link
              to="/register"
              className="full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default subtitle-1 embedded-register-button mr-6 text-decoration-none white--text"
              style={{
                backgroundColor: 'rgb(0, 128, 246)',
                borderRadius: 8,
                fontSize: '14px !important',
              }}
            >
              <span className="v-btn__content">এখনি যোগদিন</span>
            </Link>
            <button
              type="button"
              className="currency-language-dialog-trigger pt-0 language_container v-btn v-btn--icon v-btn--round theme--light v-size--small"
              onClick={onCurrencyClick}
              aria-label="Currency and language"
            >
              <span className="v-btn__content">
                <div style={{ display: 'flex', alignItems: 'center' }}>
                  <div className="v-avatar language-button" style={{ height: 40, minWidth: 40, width: 40 }}>
                    <img src="/static/image/country/BDT.svg" alt="" />
                  </div>
                  <i aria-hidden="true" className="v-icon notranslate largerIcon mdi mdi-menu-down theme--light"></i>
                </div>
              </span>
            </button>
          </div>
          <div className="text-right hidden-md-and-up col col-12">
            <Link
              to="/login"
              className="mr-1 primary-button embedded-mobile-login-button font-weight-bold yellow--text v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default black text-decoration-none"
            >
              <span className="v-btn__content">লগইন করুন</span>
            </Link>
            <Link
              to="/register"
              className="full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default buttonPrimary theme-button embedded-mobile-register-button text-decoration-none"
            >
              <span className="v-btn__content">নিবন্ধন করুন</span>
            </Link>
          </div>
        </div>
      </div>
    </div>
  )
}
