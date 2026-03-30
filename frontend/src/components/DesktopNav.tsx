import { Link } from 'react-router-dom'
import { navPageEntries } from '../config/navPages'

/** Static guest nav from `desktop-nav.blade.php` + `nav_pages` (no DB). */
export function DesktopNav() {
  return (
    <div className="page-navigator hidden-sm-and-down">
      {navPageEntries.map(([path, meta]) => (
        <div key={path} className="page-navigator-item">
          <Link
            to={`/${path}`}
            className="pt-4 pb-2 px-0 page-navigator-button text-capitalize v-btn v-btn--text theme--dark v-size--default"
            style={{ height: 'auto' }}
          >
            <span className="v-btn__content">
              <div className="row no-gutters">
                <div className="pa-0 text-center col col-12">
                  <label className="subtitle-1">{meta.heading}</label>
                </div>
                <div className="px-0 py-1 underline_bar col col-12">
                  <hr
                    role="separator"
                    aria-orientation="horizontal"
                    className="mx-2 add_border_bold v-divider theme--dark"
                  />
                </div>
              </div>
            </span>
          </Link>
        </div>
      ))}
    </div>
  )
}
