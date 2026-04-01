import { Link } from 'react-router-dom'
import { useLocation } from 'react-router-dom'
import { readAuthUser } from '../lib/authFormFetch'

/** `bottom-nav.blade.php` — guest strip. */
export function BottomNav() {
  const location = useLocation()
  const isLoggedIn = !!readAuthUser()
  const path = location.pathname

  if (isLoggedIn) {
    const items = [
      {
        to: '/referral/tier',
        label: 'সুপারিশ',
        icon: '/static/svg/mobileBottomNavigation/icon_referral.svg',
        iconActive: '/static/svg/mobileBottomNavigation/icon_referral_active.svg',
      },
      { to: '/promotion', label: 'প্রমোশন', icon: '/static/svg/mobileBottomNavigation/icon_promotion.svg' },
      {
        to: '/',
        label: 'বাড়ি',
        icon: '/static/svg/mobileBottomNavigation/icon_home.svg',
        iconActive: '/static/svg/mobileBottomNavigation/icon_home_active.svg',
      },
      { to: '/vip/vipProfile', label: 'বেটিং পাস', icon: '/static/svg/mobileBottomNavigation/icon_bettingpass.svg' },
      { to: '/reward/rewardStore', label: 'পুরস্কার', icon: '/static/svg/mobileBottomNavigation/icon_rewards.svg' },
    ]

    return (
      <div className="mobile-navigator hidden-md-and-up">
        <div className="row no-gutters">
          {items.map((item) => {
            const active =
              item.to === '/'
                ? path === '/'
                : item.to === '/referral/tier'
                ? path.startsWith('/referral/') || path.startsWith('/profile/referral/')
                : path.startsWith(item.to)
            return (
              <div key={item.to} className="grow col col-auto">
                <Link
                  to={item.to}
                  className={`v-btn v-btn--has-bg v-btn--tile theme--light v-size--default text-decoration-none${active ? ' link-active v-btn--active' : ''}`}
                  style={{ height: 'auto' }}
                >
                  <span className="v-btn__content">
                    <div className="text-center">
                      <img alt="" src={active && item.iconActive ? item.iconActive : item.icon} className="icon_btm_nav" />
                      <p className="bottom-navigator-text">{item.label}</p>
                    </div>
                  </span>
                </Link>
              </div>
            )
          })}
        </div>
      </div>
    )
  }

  return (
    <div className="bottom-navigator d-md-none">
      <div className="row bottom-navigator-before-login no-gutters">
        <Link
          to="/register"
          className="bottom-navigator-before-login-first d-flex justify-center align-center no-gutters col col-6 text-decoration-none"
          style={{ color: 'inherit' }}
        >
          <b>এখনি যোগদিন</b>
        </Link>
        <Link
          to="/login"
          className="bottom-navigator-before-login-second d-flex justify-center align-center no-gutters col col-6 text-decoration-none"
          style={{ color: 'inherit' }}
        >
          <b>লগইন করুন</b>
        </Link>
      </div>
    </div>
  )
}
