import { Link } from 'react-router-dom'
import { navPageEntries } from '../config/navPages'

type Props = {
  open: boolean
  onClose: () => void
  onLanguageClick: () => void
}

function DrawerLink({
  to,
  onNavigate,
  children,
}: {
  to: string
  onNavigate: () => void
  children: React.ReactNode
}) {
  return (
    <Link
      to={to}
      className="v-list-item v-list-item--link theme--light"
      tabIndex={0}
      role="option"
      aria-selected="false"
      onClick={onNavigate}
    >
      <div className="v-list-item__content">
        <div className="v-list-item__title">{children}</div>
      </div>
    </Link>
  )
}

/** Simplified `navigation-drawer.blade.php` — static links from `nav_pages`. */
export function NavigationDrawer({ open, onClose, onLanguageClick }: Props) {
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
              <img src="/static/svg/babu88_logo_black.svg" alt="" width={180} height={30} className="mt-4" />
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
            <DrawerLink to="/" onNavigate={onClose}>
              হোম
            </DrawerLink>
            {navPageEntries.slice(0, 6).map(([path, meta]) => (
              <DrawerLink key={path} to={`/${path}`} onNavigate={onClose}>
                {meta.heading}
              </DrawerLink>
            ))}
          </div>
          <hr role="separator" aria-orientation="horizontal" className="my-4 mx-4 v-divider theme--light" />
          <span className="mobile-drawer-itemgroup-title">Games</span>
          <div role="listbox" className="v-item-group theme--light v-list-item-group">
            {navPageEntries.slice(6).map(([path, meta]) => (
              <DrawerLink key={path} to={`/${path}`} onNavigate={onClose}>
                {meta.heading}
              </DrawerLink>
            ))}
          </div>
          <hr role="separator" aria-orientation="horizontal" className="my-4 mx-4 v-divider theme--light" />
          <span className="mobile-drawer-itemgroup-title">Others</span>
          <div role="listbox" className="v-item-group theme--light v-list-item-group">
            <div tabIndex={0} role="option" aria-selected="false" className="v-list-item v-list-item--link theme--light">
              <div className="v-list-item__icon">
                <button
                  type="button"
                  className="v-btn v-btn--icon v-btn--round theme--light v-size--small"
                  style={{ marginLeft: -3 }}
                  onClick={() => onLanguageClick()}
                  aria-label="ভাষা — Currency and language"
                >
                  <span className="v-btn__content">
                    <div className="v-avatar language-button" style={{ height: 25, minWidth: 25, width: 25 }}>
                      <img src="/static/svg/mobileMenu/icon_language.svg" alt="" />
                    </div>
                  </span>
                </button>
              </div>
              <div className="v-list-item__content">
                <div className="v-list-item__title">ভাষা</div>
              </div>
            </div>
            <div tabIndex={0} role="option" aria-selected="false" className="v-list-item v-list-item--link theme--light">
              <div className="v-list-item__icon">
                <button type="button" className="v-btn v-btn--icon v-btn--round theme--light v-size--small" style={{ marginLeft: -3 }}>
                  <span className="v-btn__content">
                    <div className="v-avatar" style={{ height: 25, minWidth: 25, width: 25 }}>
                      <img src="/static/svg/mobileMenu/liveChat.svg" alt="" />
                    </div>
                  </span>
                </button>
              </div>
              <div className="v-list-item__content">
                <div className="v-list-item__title">সরাসরি কথোপকথন</div>
              </div>
            </div>
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
                <div className="v-list-item__title">ডাউনলোড করুন</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="v-navigation-drawer__border"></div>
    </aside>
  )
}
