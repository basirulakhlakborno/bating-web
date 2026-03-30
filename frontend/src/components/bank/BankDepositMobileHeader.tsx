import { NavLink } from 'react-router-dom'

/** Deposit / withdrawal tabs shown above the card on small screens. */
export function BankDepositMobileHeader() {
  return (
    <div className="row hidden-md-and-up mobile-header no-gutters">
      <div className="text-center mobile-header-item col col-6">
        <NavLink
          to="/bank/deposit"
          end
          className={({ isActive }) =>
            `bank-mobile-tab-link${isActive ? ' bank-mobile-tab-link--active' : ''}`
          }
        >
          <span>আমানত</span>
        </NavLink>
      </div>
      <div className="text-center mobile-header-item col col-6">
        <NavLink
          to="/bank/withdrawal"
          className={({ isActive }) =>
            `bank-mobile-tab-link${isActive ? ' bank-mobile-tab-link--active' : ''}`
          }
        >
          <span>উত্তোলন</span>
        </NavLink>
      </div>
    </div>
  )
}
