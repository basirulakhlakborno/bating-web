import type { ReactNode } from 'react'
import { BankProfileNav } from '../profile/BankProfileNav'
import { ProfileSidePanel, type ProfileSidePanelProps } from '../profile/ProfileSidePanel'

/** Left / right columns for 2-8-2 bank pages (matches legacy `col-md-2` + `col-8`). */
export const bankSidePanelColumnClass =
  'bank-profile-side-panel hidden-sm-and-down mt-4 col col-12 col-md-2 col-lg-2'

/** Default main column for deposit (2-8-2). */
export const bankMainDefaultClass = 'col col-12 col-md-8 col-lg-8'
/** Wider main for transaction history (2-10, no right rail). */
export const bankMainWideClass = 'col col-12 col-md-10 col-lg-10'

export type BankPageLayoutProps = {
  side: ProfileSidePanelProps
  /** Optional right column (e.g. deposit notices). */
  rightRail?: ReactNode
  children: ReactNode
  /** Grid classes for main column; default 8/12, history uses {@link bankMainWideClass}. */
  mainColumnClassName?: string
}

/** Shell for `/bank/*` pages: top nav + optional 3-column row (side | main | notices). */
export function BankPageLayout({
  side,
  rightRail,
  children,
  mainColumnClassName = bankMainDefaultClass,
}: BankPageLayoutProps) {
  const wideMain = mainColumnClassName.includes('col-md-10')
  return (
    <div className="profileLayout-padding mobile-full-height margin-desktop">
      <BankProfileNav />
      <div
        className={`row layout-col-wrapper no-gutters${rightRail ? ' bank-three-col' : ''}${wideMain && !rightRail ? ' bank-wide-main' : ''}`}
      >
        <ProfileSidePanel {...side} columnClassName={bankSidePanelColumnClass} />
        <div className={`bank-mid ${mainColumnClassName}`}>
          <div className="px-0" style={{ height: '100%' }}>
            {children}
          </div>
        </div>
        {rightRail}
      </div>
    </div>
  )
}
