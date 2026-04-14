import { Link } from 'react-router-dom'
import { useSiteLayout } from '../hooks/useSiteLayout'
import { normalizeInternalNavHref } from '../config/navRouting'
import type { NavItem } from '../hooks/useSiteLayout'

/** Desktop nav from `navigation_items` (admin). */
export function DesktopNav() {
  const layout = useSiteLayout()
  const items: NavItem[] = layout?.layoutDesktopNav ?? []
  if (items.length === 0) {
    return null
  }

  return (
    <div className="page-navigator hidden-sm-and-down">
      {items.map((item) => {
        const href = normalizeInternalNavHref(item.href?.trim() ?? '#')
        const isHttp = href.startsWith('http://') || href.startsWith('https://')
        const external = Boolean(item.is_external) && isHttp
        const inner = (
          <span className="v-btn__content">
            <div className="row no-gutters">
              <div className="pa-0 text-center col col-12">
                <label className="subtitle-1">{item.label_bn}</label>
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
        )
        return (
          <div key={item.id} className="page-navigator-item">
            {isHttp ? (
              <a
                href={href}
                className="pt-4 pb-2 px-0 page-navigator-button text-capitalize v-btn v-btn--text theme--dark v-size--default"
                style={{ height: 'auto' }}
                {...(external ? { target: '_blank', rel: 'noopener noreferrer' } : {})}
              >
                {inner}
              </a>
            ) : (
              <Link
                to={href}
                className="pt-4 pb-2 px-0 page-navigator-button text-capitalize v-btn v-btn--text theme--dark v-size--default"
                style={{ height: 'auto' }}
              >
                {inner}
              </Link>
            )}
          </div>
        )
      })}
    </div>
  )
}
