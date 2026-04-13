import { Link } from 'react-router-dom'
import { useState } from 'react'
import { useSiteLayout } from '../hooks/useSiteLayout'
import { clearAuthStorage } from '../lib/authFormFetch'
import { useAuthUserSnapshot } from '../lib/useAuthUserSnapshot'
import { formatInboxBadgeCount, useInboxUnreadCount } from '../lib/useInboxUnreadCount'

type Props = {
  onCurrencyClick: () => void
}

/** Guest actions from `desktop-header.blade.php` (@else branch). */
export function DesktopHeader({ onCurrencyClick }: Props) {
  const layout = useSiteLayout()
  const headerLogoSrc = layout?.layoutSiteHeaderLogoPath ?? ''
  const user = useAuthUserSnapshot()
  const inboxUnread = useInboxUnreadCount()
  const session = user ? { isLoggedIn: true, username: user.username || 'ব্যবহারকারী' } : { isLoggedIn: false, username: '' }
  const [showBalance, setShowBalance] = useState(false)

  const symbol = user?.currency_symbol || '৳'
  const numericBalance = Number(user?.balance ?? 0)
  const formattedBalance = Number.isFinite(numericBalance) ? `${numericBalance.toFixed(2)}` : '0.00'

  const onLogout = () => {
    clearAuthStorage()
    window.location.assign('/')
  }

  return (
    <div className="row hidden-sm-and-down header-top no-gutters align-center justify-space-between">
      <div className="header-column col col-5 header-logo-col">
        <Link to="/" className="router-link-active header-logo-link">
          {headerLogoSrc ? (
            <img
              src={headerLogoSrc}
              alt=""
              className="desktop-header-logo-img"
              decoding="async"
            />
          ) : null}
        </Link>
      </div>
      <div className="header-column register-dialog text-right col-md-6 col-lg-5 col-5">
        <div className="row no-gutters justify-end">
          <div className="text-right hidden-sm-and-down col col-12">
            {session.isLoggedIn ? (
              <div className="greeting-text font-weight-bold header-auth-actions">
                <Link
                  to="/profile/personal"
                  className="color-primary greeting-text-btn header-auth-username text-decoration-none"
                  style={{ cursor: 'pointer' }}
                >
                  {session.username}
                </Link>

                <Link
                  to="/profile/personal"
                  className="circle header-vector-btn v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none"
                  aria-label="সুপারিশ / রেফারেল"
                >
                  <span className="v-btn__content">
                    <img src="/static/image/other/vector.svg" alt="" width={20} height={20} />
                  </span>
                </Link>

                <Link
                  to="/profile/inbox"
                  className="circle header-inbox-btn v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none"
                  aria-label={inboxUnread > 0 ? `ইনবক্স, ${inboxUnread} নোটিফিকেশন` : 'ইনবক্স'}
                >
                  <span className="v-btn__content">
                    <img src="/static/image/other/notification.svg" alt="" width={20} height={20} />
                    {inboxUnread > 0 ? (
                      <span className="v-badge theme--light" style={{ zIndex: 10 }}>
                        <span className="v-badge__wrapper">
                          <span
                            aria-atomic="true"
                            aria-label={`${inboxUnread} unread`}
                            aria-live="polite"
                            role="status"
                            className="v-badge__badge"
                            style={{
                              inset: 'auto auto calc(100% + 0px) calc(100% + 0px)',
                              backgroundColor: 'rgb(0, 128, 246)',
                              borderColor: 'rgb(0, 128, 246)',
                            }}
                          >
                            {formatInboxBadgeCount(inboxUnread)}
                          </span>
                        </span>
                      </span>
                    ) : null}
                  </span>
                </Link>

                <hr role="separator" aria-orientation="vertical" className="v-divider v-divider--vertical theme--light" />

                <button
                  type="button"
                  className="color-base header-wallet v-chip v-chip--clickable v-chip--no-color v-chip--pill theme--light v-size--default"
                  onClick={() => setShowBalance((v) => !v)}
                  aria-label={showBalance ? 'Hide balance' : 'Show balance'}
                >
                  <span className="v-chip__content">
                    <label className="text-capitalize balance">
                      <span>{showBalance ? `${symbol} ${formattedBalance}` : `${symbol} *.**`}</span>
                    </label>
                  </span>
                </button>

                <div style={{ position: 'relative', display: 'inline-block' }}>
                  <button
                    type="button"
                    className="v-icon notranslate color-primary header-wallet-icon v-icon--left v-icon--link material-icons theme--light"
                    style={{ fontSize: 50, color: 'rgb(0, 128, 246)', zIndex: 1 }}
                  >
                    add_circle
                  </button>
                </div>

                <button
                  type="button"
                  className="currency-language-dialog-trigger header-language-btn pt-0 language_container v-btn v-btn--icon v-btn--round theme--light v-size--small"
                  onClick={onCurrencyClick}
                  aria-label="Currency and language"
                >
                  <span className="v-btn__content">
                    <div style={{ display: 'flex', alignItems: 'center' }}>
                      <div className="v-avatar language-button" style={{ height: 40, minWidth: 40, width: 40 }}>
                        <img src="/static/image/country/BDT.svg" alt="" />
                      </div>
                      <i aria-hidden="true" className="v-icon notranslate mdi mdi-menu-down theme--light"></i>
                    </div>
                  </span>
                </button>

                <button type="button" className="elevation-0 header-logout-btn v-btn v-btn--icon v-btn--round theme--light v-size--small" onClick={onLogout}>
                  <span className="v-btn__content">
                    <img src="/static/svg/mobileMenu/logout.svg" alt="" width={30} height={30} />
                  </span>
                </button>
              </div>
            ) : (
              <>
                <Link
                  to="/login"
                  className="header-guest-auth-btn mr-6 embedded-login-button pa-2 font-weight-bold black--text v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none"
                  style={{
                    height: 'auto',
                    backgroundColor: 'rgb(255, 206, 1)',
                    borderColor: 'rgb(255, 206, 1)',
                    borderRadius: 8,
                  }}
                >
                  <span className="v-btn__content">লগইন করুন</span>
                </Link>
                <Link
                  to="/register"
                  className="header-guest-auth-btn full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default embedded-register-button mr-6 text-decoration-none white--text"
                  style={{
                    backgroundColor: 'rgb(0, 128, 246)',
                    borderRadius: 8,
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
              </>
            )}
          </div>
          <div className="text-right hidden-md-and-up col col-12">
            <Link
              to="/login"
              className="header-guest-auth-btn mr-1 primary-button embedded-mobile-login-button font-weight-bold yellow--text v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default black text-decoration-none"
            >
              <span className="v-btn__content">লগইন করুন</span>
            </Link>
            <Link
              to="/register"
              className="header-guest-auth-btn full-width font-weight-bold pa-2 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default buttonPrimary theme-button embedded-mobile-register-button text-decoration-none"
            >
              <span className="v-btn__content">নিবন্ধন করুন</span>
            </Link>
          </div>
        </div>
      </div>
    </div>
  )
}
