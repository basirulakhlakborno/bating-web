import { NavLink } from 'react-router-dom'
import { bankProfileNavItems } from '../../config/bankProfileNav'

function NavLinks() {
  return (
    <>
      {bankProfileNavItems.map((item) => (
        <div key={String(item.to)} className="nav-item">
          <NavLink
            to={item.to}
            end
            className={({ isActive }) =>
              `nav-btn v-btn v-btn--is-elevated v-btn--has-bg v-btn--router theme--light v-size--default${isActive ? ' v-btn--active active-page' : ''}`
            }
          >
            <span className="v-btn__content">{item.label}</span>
          </NavLink>
        </div>
      ))}
    </>
  )
}

export function BankProfileNav() {
  return (
    <>
      <div className="bankPage-navigationBar bankPage-navigationBar--desktop row hidden-sm-and-down">
        <NavLinks />
      </div>
      <div className="bankPage-navigationBar bankPage-navigationBar--mobile hidden-md-and-up">
        <div className="bankPage-navigationBar-scroll" role="navigation" aria-label="ব্যাংক ও প্রোফাইল">
          <NavLinks />
        </div>
      </div>
    </>
  )
}
