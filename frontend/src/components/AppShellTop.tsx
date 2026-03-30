import { DownloadBar } from './DownloadBar'
import { MobileHeader } from './MobileHeader'
import { DesktopHeader } from './DesktopHeader'
import { DesktopNav } from './DesktopNav'
import { NavigationDrawer } from './NavigationDrawer'

type Props = {
  drawerOpen: boolean
  onDrawerOpenChange: (open: boolean) => void
  onOpenCurrency: () => void
}

/** Mirrors `<x-app-shell-top />` order from Blade. */
export function AppShellTop({ drawerOpen, onDrawerOpenChange, onOpenCurrency }: Props) {
  return (
    <>
      <DownloadBar />
      <div className="row no-gutters">
        <MobileHeader onMenuClick={() => onDrawerOpenChange(true)} onCurrencyClick={onOpenCurrency} />
      </div>
      <NavigationDrawer open={drawerOpen} onClose={() => onDrawerOpenChange(false)} onLanguageClick={onOpenCurrency} />
      <DesktopHeader onCurrencyClick={onOpenCurrency} />
      <DesktopNav />
    </>
  )
}
