import { Link } from 'react-router-dom'

/** `bottom-nav.blade.php` — guest strip. */
export function BottomNav() {
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
