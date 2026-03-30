import { useState } from 'react'
import { Outlet, useLocation } from 'react-router-dom'
import { AppShellTop } from '../components/AppShellTop'
import { BottomNav } from '../components/BottomNav'
import { Footer } from '../components/Footer'
import { GlobalOverlays } from '../components/GlobalOverlays'
import { SubNavigators } from '../components/SubNavigators'

/** Shell from `home.blade.php` / `login.blade.php` — `body` vs `body auth-page-body`. */
export function Babu88Layout() {
  const [drawerOpen, setDrawerOpen] = useState(false)
  const [currencyOpen, setCurrencyOpen] = useState(false)
  const location = useLocation()
  const path = location.pathname.replace(/\/$/, '') || '/'
  const useMainBody =
    path === '/' ||
    path.startsWith('/profile') ||
    path.startsWith('/bank')
  const bodyClass = useMainBody ? 'body' : 'body auth-page-body'

  return (
    <div data-app="true" className="v-application v-application--is-ltr theme--light" id="app">
      <div className="v-application--wrap">
        <div>
          <AppShellTop
            drawerOpen={drawerOpen}
            onDrawerOpenChange={setDrawerOpen}
            onOpenCurrency={() => {
              setDrawerOpen(false)
              setCurrencyOpen(true)
            }}
          />

          <div className={bodyClass}>
            <Outlet />
            <Footer />
          </div>

          <BottomNav />

          <GlobalOverlays
            drawerOpen={drawerOpen}
            onCloseDrawer={() => setDrawerOpen(false)}
            currencyOpen={currencyOpen}
            onCloseCurrency={() => setCurrencyOpen(false)}
          />
        </div>
      </div>

      <SubNavigators />
    </div>
  )
}
