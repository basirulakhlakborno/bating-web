import { Link } from 'react-router-dom'

type Props = {
  onMenuClick: () => void
  onCurrencyClick: () => void
}

/** Guest toolbar from `mobile-header.blade.php` (@else branch). */
export function MobileHeader({ onMenuClick, onCurrencyClick }: Props) {
  return (
    <div className="full-width hidden-md-and-up header-top mobile elevation-3 col col-12">
      <div className="row no-gutters align-center">
        <div className="px-3 col col-12">
          <div className="row no-gutters align-center justify-space-between">
            <div className="text-left col col-1">
              <button
                type="button"
                className="v-app-bar__nav-icon v-btn v-btn--icon v-btn--round theme--light v-size--default"
                style={{ height: 18, width: 22 }}
                onClick={onMenuClick}
                aria-label="Open menu"
              >
                <span className="v-btn__content">
                  <i aria-hidden="true" className="v-icon notranslate mdi mdi-menu theme--light"></i>
                </span>
              </button>
            </div>
            <div className="mobile-header-logo col col-9">
              <Link to="/" className="router-link-active" style={{ display: 'flex', alignItems: 'center' }}>
                <img src="/static/svg/bb88_logo_animation2.gif" alt="" width={215} height={45} />
              </Link>
            </div>
            <div
              className="text-right col col-2 d-flex align-center justify-end logged-in-mobile-toolbar"
              style={{ gap: 2, flexWrap: 'nowrap' }}
            >
              <button
                type="button"
                className="currency-language-dialog-trigger v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default"
                style={{
                  width: 55,
                  cursor: 'pointer',
                  backgroundColor: 'rgb(218, 218, 218)',
                  paddingLeft: 5,
                }}
                onClick={onCurrencyClick}
                aria-label="Currency and language"
              >
                <span className="v-btn__content">
                  <div className="v-avatar language-button" style={{ height: 25, minWidth: 25, width: 25 }}>
                    <img src="/static/image/country/BDT.svg" alt="" />
                  </div>
                  <i aria-hidden="true" className="v-icon notranslate largerIcon mdi mdi-menu-down theme--light"></i>
                </span>
              </button>
            </div>
            <div className="spacer"></div>
          </div>
        </div>
      </div>
    </div>
  )
}
