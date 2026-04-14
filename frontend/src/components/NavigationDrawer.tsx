import { Link } from 'react-router-dom'
import { useSiteLayout, type NavItem } from '../hooks/useSiteLayout'
import { openIntercomMessenger } from '../lib/intercom'
import { normalizeInternalNavHref } from '../config/navRouting'

type Props = {
  open: boolean
  onClose: () => void
  onLanguageClick: () => void
}

function DrawerNavLink({
  item,
  onNavigate,
}: {
  item: NavItem
  onNavigate: () => void
}) {
  const href = normalizeInternalNavHref(item.href?.trim() ?? '#')
  const isHttp = href.startsWith('http://') || href.startsWith('https://')
  const external = Boolean(item.is_external) && isHttp
  const cls = 'v-list-item v-list-item--link theme--light'
  const icon = item.icon_path ? (
    <div className="v-list-item__icon">
      <span className="v-btn v-btn--icon v-btn--round theme--light v-size--small" style={{ marginLeft: -3, display: 'inline-flex', pointerEvents: 'none' }}>
        <span className="v-btn__content">
          <div className="v-avatar" style={{ height: 25, minWidth: 25, width: 25 }}>
            <img src={item.icon_path} alt="" />
          </div>
        </span>
      </span>
    </div>
  ) : null
  const body = (
    <>
      {icon}
      <div className="v-list-item__content">
        <div className="v-list-item__title">{item.label_bn}</div>
      </div>
    </>
  )

  if (isHttp) {
    return (
      <a
        href={href}
        className={cls}
        tabIndex={0}
        role="option"
        aria-selected="false"
        onClick={onNavigate}
        {...(external ? { target: '_blank', rel: 'noopener noreferrer' } : {})}
      >
        {body}
      </a>
    )
  }
  return (
    <Link to={href} className={cls} tabIndex={0} role="option" aria-selected="false" onClick={onNavigate}>
      {body}
    </Link>
  )
}

/** Drawer links from `navigation_items` (admin), grouped like production. */
export function NavigationDrawer({ open, onClose, onLanguageClick }: Props) {
  const layout = useSiteLayout()
  const drawerLogoSrc = layout?.layoutSiteDrawerLogoPath ?? ''
  const top = layout?.layoutDrawerTop ?? []
  const games = layout?.layoutDrawerGames ?? []
  const others = layout?.layoutDrawerOthers ?? []

  return (
    <aside
      className="mobile-navigation-drawer v-navigation-drawer v-navigation-drawer--absolute v-navigation-drawer--is-mobile v-navigation-drawer--temporary theme--light"
      style={{
        height: '100%',
        top: 0,
        left: 0,
        width: 256,
        position: 'fixed',
        zIndex: 400,
        transform: open ? 'translateX(0)' : 'translateX(-100%)',
        transition: 'transform 0.25s ease',
        background: '#fff',
      }}
    >
      <div className="v-navigation-drawer__content">
        <div className="row">
          <div className="mobile-drawer-menu-header-section col col-12">
            <Link to="/" className="mobile-drawer-menu-logo router-link-active" onClick={onClose}>
              {drawerLogoSrc ? (
                <img src={drawerLogoSrc} alt="" className="drawer-menu-logo-img mt-4" decoding="async" />
              ) : null}
            </Link>
            <button
              type="button"
              className="v-icon notranslate mobile-drawer-menu-icon v-icon--link mdi mdi-menu theme--light"
              onClick={onClose}
              aria-label="Close menu"
            />
          </div>
        </div>
        <hr role="separator" aria-orientation="horizontal" className="my-4 mx-4 v-divider theme--light" />
        <div role="list" className="v-list pb-16 mobileMenuListItem v-sheet theme--light v-list--dense v-list--nav">
          <div role="listbox" className="v-item-group theme--light v-list-item-group">
            <Link
              to="/"
              className="v-list-item v-list-item--link theme--light"
              tabIndex={0}
              role="option"
              aria-selected="false"
              onClick={onClose}
            >
              <div className="v-list-item__content">
                <div className="v-list-item__title">হোম</div>
              </div>
            </Link>
            {top.map((item) => (
              <DrawerNavLink key={item.id} item={item} onNavigate={onClose} />
            ))}
          </div>
          <hr role="separator" aria-orientation="horizontal" className="my-4 mx-4 v-divider theme--light" />
          <span className="mobile-drawer-itemgroup-title">Games</span>
          <div role="listbox" className="v-item-group theme--light v-list-item-group">
            {games.map((item) => (
              <DrawerNavLink key={item.id} item={item} onNavigate={onClose} />
            ))}
          </div>
          <hr role="separator" aria-orientation="horizontal" className="my-4 mx-4 v-divider theme--light" />
          <span className="mobile-drawer-itemgroup-title">Others</span>
          <div role="listbox" className="v-item-group theme--light v-list-item-group">
            {others.map((item) => (
              <DrawerNavLink key={item.id} item={item} onNavigate={onClose} />
            ))}
            <div tabIndex={0} role="option" aria-selected="false" className="v-list-item v-list-item--link theme--light">
              <div className="v-list-item__icon">
                <button
                  type="button"
                  className="v-btn v-btn--icon v-btn--round theme--light v-size--small"
                  style={{ marginLeft: -3 }}
                  onClick={() => onLanguageClick()}
                  aria-label="Language — Currency and language"
                >
                  <span className="v-btn__content">
                    <div className="v-avatar language-button" style={{ height: 25, minWidth: 25, width: 25 }}>
                      <img src="/static/svg/mobileMenu/icon_language.svg" alt="" />
                    </div>
                  </span>
                </button>
              </div>
              <div className="v-list-item__content">
                <div className="v-list-item__title">Language</div>
              </div>
            </div>
            <button
              type="button"
              role="option"
              aria-selected="false"
              className="v-list-item v-list-item--link theme--light"
              style={{
                width: '100%',
                border: 'none',
                background: 'transparent',
                cursor: 'pointer',
                textAlign: 'left',
                padding: 0,
                font: 'inherit',
                color: 'inherit',
              }}
              onClick={() => {
                onClose()
                void openIntercomMessenger()
              }}
            >
              <div className="v-list-item__icon">
                <span className="v-btn v-btn--icon v-btn--round theme--light v-size--small" style={{ marginLeft: -3, display: 'inline-flex', pointerEvents: 'none' }}>
                  <span className="v-btn__content">
                    <div className="v-avatar" style={{ height: 25, minWidth: 25, width: 25 }}>
                      <img src="/static/svg/mobileMenu/liveChat.svg" alt="" />
                    </div>
                  </span>
                </span>
              </div>
              <div className="v-list-item__content">
                <div className="v-list-item__title">সরাসরি কথোপকথন</div>
              </div>
            </button>
            <div tabIndex={0} role="option" aria-selected="false" className="v-list-item v-list-item--link theme--light">
              <div className="v-list-item__icon">
                <button type="button" className="v-btn v-btn--icon v-btn--round theme--light v-size--small" style={{ marginLeft: -3 }}>
                  <span className="v-btn__content">
                    <div className="v-avatar" style={{ height: 25, minWidth: 25, width: 25 }}>
                      <img src="/static/svg/mobileMenu/icon_downloadapp.svg" alt="" />
                    </div>
                  </span>
                </button>
              </div>
              <div className="v-list-item__content">
                <div className="v-list-item__title">Download app</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="v-navigation-drawer__border"></div>
    </aside>
  )
}
