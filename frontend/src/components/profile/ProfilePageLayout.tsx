import type { ReactNode } from 'react'
import { BankProfileNav } from './BankProfileNav'
import { ProfilePersonalMobileSummary } from './ProfilePersonalMobileSummary'
import { ProfileSidePanel, type ProfileSidePanelProps } from './ProfileSidePanel'

/** Narrow sidebar + wide main (legacy `col-2` + `col-10`), e.g. change password. */
const profileSideNarrowCol =
  'bank-profile-side-panel hidden-sm-and-down mt-4 col col-12 col-md-2 col-lg-2'

export type ProfilePageLayoutProps = {
  side: ProfileSidePanelProps
  children: ReactNode
  /** Use 2+10 grid instead of default 3+9. */
  wideMainColumn?: boolean
}

/** Shell for profile routes: bank nav, mobile summary, desktop sidebar + main column. */
export function ProfilePageLayout({ side, children, wideMainColumn }: ProfilePageLayoutProps) {
  return (
    <div className="profileLayout-padding mobile-full-height margin-desktop">
      <BankProfileNav />
      <ProfilePersonalMobileSummary {...side} />
      <div
        className={`row layout-col-wrapper no-gutters${wideMainColumn ? ' profile-layout-wide-main' : ''}`}
      >
        <ProfileSidePanel {...side} columnClassName={wideMainColumn ? profileSideNarrowCol : undefined} />
        <div
          className={`bank-mid col col-12 ${wideMainColumn ? 'col-md-10 col-lg-10' : 'col-md-9 col-lg-9'}`}
        >
          <div style={{ height: '100%' }}>{children}</div>
        </div>
      </div>
    </div>
  )
}
