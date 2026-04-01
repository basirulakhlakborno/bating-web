import { type CSSProperties, useEffect, useMemo, useState } from 'react'
import { Link, useLocation } from 'react-router-dom'
import { AUTH_CHANGED_EVENT, readAuthToken, readAuthUser } from '../lib/authFormFetch'
import { type ReferralDashboard, fetchReferralDashboard } from '../lib/referralApi'

const tabs = [
  { to: '/referral/tier', key: 'tier', labelDesktop: 'Referral Tier', labelMobile: 'আমার রেফারেল' },
  { to: '/referral/summary', key: 'summary', labelDesktop: 'সারসংক্ষেপ', labelMobile: 'আমার কমিশন' },
  { to: '/referral/report', key: 'report', labelDesktop: 'রিপোর্টিং', labelMobile: 'রিপোর্টিং' },
  { to: '/referral/history', key: 'history', labelDesktop: 'ইতিহাস', labelMobile: 'ইতিহাস' },
]

const TITLE_FALLBACK = 'রেফারেল প্রোগ্রাম'

/** Match production asset URLs (babu88.gold). */
const REF_CDN = 'https://babu88.gold/static/image/referral'
const referralBannerCdn = `${REF_CDN}/referral_banner.png`
const referralInnerDesktopCdn = `${REF_CDN}/referralinnerbanner-desktop.jpg`
const referralInfoIconCdn = `${REF_CDN}/info-icon.svg`

const DESC_FALLBACK =
  'সেরা সুপারিশ কার্যক্রম এখানে! আপনি এখন প্রতিবার 2% পর্যন্ত আজীবন কমিশন উপার্জন করতে পারেন যখন আপনার দ্বারা সুপারিশ করা আপনার বন্ধু একটি আমানত জমা করে! তার উপরে, আমরা আপনাকে এবং আপনার বন্ধুকে অতিরিক্ত ৳ ৫০০ দিচ্ছি যখন আপনার দ্বারা সুপারিশ করা আপনার প্রতিটি বন্ধু মোট ৳ ২০০০ আমানত জমা করে।'

function fallbackTierRows(code: string) {
  return [
    { label: code, amount: '0', active: true },
    { label: 'Tier 1 (1.5%)', amount: '0', active: false },
    { label: 'Tier 2 (1%)', amount: '0', active: false },
    { label: 'Tier 3 (0.5%)', amount: '0', active: false },
    { label: 'Tier 4 (0.25%)', amount: '0', active: false },
  ]
}

function referralSection(path: string): 'tier' | 'summary' | 'report' | 'history' {
  if (path === '/referral/summary' || path.endsWith('/referral/summary')) return 'summary'
  if (path === '/referral/report' || path.endsWith('/referral/report')) return 'report'
  if (path === '/referral/history' || path.endsWith('/referral/history')) return 'history'
  return 'tier'
}

export function ReferralPage() {
  const { pathname } = useLocation()
  const user = readAuthUser()
  const [dashboard, setDashboard] = useState<ReferralDashboard | null>(null)

  const normalizedPath = pathname.startsWith('/profile/referral/') ? pathname.replace('/profile', '') : pathname
  const section = referralSection(normalizedPath)

  useEffect(() => {
    let gen = 0
    const load = async () => {
      const my = ++gen
      if (!readAuthToken()) {
        setDashboard(null)
        return
      }
      window.babu88PushLoading?.()
      try {
        const r = await fetchReferralDashboard()
        if (gen !== my) return
        if (r.ok) setDashboard(r.data)
        else if (r.status === 401) setDashboard(null)
      } finally {
        if (gen === my) window.babu88PopLoading?.()
      }
    }
    void load()
    const onAuth = () => void load()
    window.addEventListener(AUTH_CHANGED_EVENT, onAuth)
    return () => {
      gen += 1
      window.removeEventListener(AUTH_CHANGED_EVENT, onAuth)
    }
  }, [])

  const referralCode = dashboard?.meta.referral_code ?? user?.referral_code ?? user?.username ?? '—'
  const titleBn = dashboard?.meta.title_bn?.trim() ? dashboard.meta.title_bn : TITLE_FALLBACK
  const descText = dashboard?.meta.description_bn?.trim() ? dashboard.meta.description_bn : DESC_FALLBACK

  const tierRows = useMemo(() => {
    if (dashboard?.tiers?.length) {
      return dashboard.tiers.map((t) => ({
        label: t.slug === 'direct' ? referralCode : t.label,
        amount: t.amount,
        active: t.active,
      }))
    }
    return fallbackTierRows(referralCode === '—' ? 'GM2N6C0134' : referralCode)
  }, [dashboard, referralCode])

  const tierTimeline = (prefix: string) => (
    <div className="v-timeline v-timeline--dense theme--light referral-tier-timeline">
      {tierRows.map((tier, idx) => (
        <div key={`${prefix}-${idx}`} className={`v-timeline-item v-timeline-item--fill-dot theme--light${tier.active ? ' active-tier' : ''}`}>
          <div className="v-timeline-item__body">
            <div className="row referral-tier-row" style={{ alignItems: 'center' }}>
              <div className="col referral-tier-label-col">
                <div className={`tier-card text-center v-card v-sheet theme--light${tier.active ? ' active-tier' : ' grey lighten-2'}`}>
                  <div className="v-card__text">{tier.label}</div>
                </div>
              </div>
              <div className="col referral-tier-value-col" style={{ padding: 'unset' }}>
                <div
                  className={`tier-value-card v-card v-sheet theme--light text-center${tier.active ? ' tier-card active-tier' : ' tier-card grey lighten-2'}`}
                >
                  <div className="v-card__text tier-card text-center">{tier.amount}</div>
                </div>
              </div>
            </div>
          </div>
          <div className="v-timeline-item__divider">
            <div className="v-timeline-item__dot">
              <div className="v-timeline-item__inner-dot grey lighten-2">
                <img src="/static/svg/tier-icon.svg" style={{ width: 22 }} alt="" />
              </div>
            </div>
          </div>
        </div>
      ))}
    </div>
  )

  /** Desktop inner row: promo banner (text centered over background). */
  const desktopInnerBannerRow = (
    <div className="row px-4 no-gutters referral-inner-banner-row" style={{ position: 'relative' }}>
      <span className="v-badge inner-banner-badge theme--light" {...({ top: '', right: '' } as Record<string, string>)}>
        <div className="v-image v-responsive newReferralBanner-desktop theme--light">
          <div className="v-responsive__sizer referral-inner-banner-sizer"></div>
          <div
            className="v-image__image v-image__image--cover"
            style={{ backgroundImage: `url("${referralInnerDesktopCdn}")`, backgroundPosition: 'center center' }}
          ></div>
          <div className="v-responsive__content">
            <div className="banner-desc">
              <span>আপনাৱ রেফার করা প্রতিটি বন্ধু, আপনি বিনামূল্যে পেতে</span>
              <h1>৳500 </h1>
              <span>আপনার বন্ধুরাও বিনামূল্যে ৳500 পাবেন! </span>
            </div>
          </div>
        </div>
        <span className="v-badge__wrapper">
          <span
            aria-atomic="true"
            aria-label="Badge"
            aria-live="polite"
            role="status"
            className="v-badge__badge light"
            style={{ inset: 'auto auto calc(83%) calc(95%)' }}
          >
            <div className="v-image v-responsive theme--light" style={{ height: 25, width: 25, cursor: 'pointer' }}>
              <div className="v-responsive__sizer" style={{ paddingBottom: '100%' }}></div>
              <div
                className="v-image__image v-image__image--cover"
                style={{ backgroundImage: `url("${referralInfoIconCdn}")`, backgroundPosition: 'center center' }}
              ></div>
              <div className="v-responsive__content" style={{ width: 20 }}></div>
            </div>
          </span>
        </span>
      </span>
    </div>
  )

  /** Duplicate block inside mobile layout: hidden-sm-and-down + preload placeholders (same as production markup). */
  const mobileDuplicateHiddenSmDown = (
    <div className="hidden-sm-and-down">
      <div>
        <div className="row px-4 no-gutters referral-inner-banner-row" style={{ position: 'relative' }}>
          <span className="v-badge inner-banner-badge theme--light" {...({ top: '', right: '' } as Record<string, string>)}>
            <div className="v-image v-responsive newReferralBanner-desktop theme--light">
              <div className="v-responsive__sizer referral-inner-banner-sizer"></div>
              <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
              <div className="v-responsive__content">
                <div className="banner-desc">
                  <span>আপনাৱ রেফার করা প্রতিটি বন্ধু, আপনি বিনামূল্যে পেতে</span>
                  <h1>৳500 </h1>
                  <span>আপনার বন্ধুরাও বিনামূল্যে ৳500 পাবেন! </span>
                </div>
              </div>
            </div>
            <span className="v-badge__wrapper">
              <span
                aria-atomic="true"
                aria-label="Badge"
                aria-live="polite"
                role="status"
                className="v-badge__badge light"
                style={{ inset: 'auto auto calc(83%) calc(95%)' }}
              >
                <div className="v-image v-responsive theme--light" style={{ height: 25, width: 25, cursor: 'pointer' }}>
                  <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
                  <div className="v-responsive__content"></div>
                </div>
              </span>
            </span>
          </span>
        </div>
        <div className="spacer"></div>
        <div className="row px-4 pt-6">
          <div className="col col-12">
            <span className="referral-title">আজীবন রেফারেল কমিশন </span>
          </div>
        </div>
        <div className="row px-4 no-gutters">
          <div className="col col-12">{tierTimeline('dup')}</div>
        </div>
      </div>
    </div>
  )

  const summaryBlock = (
    <div className="row px-4 no-gutters">
      <div className="col col-12">
        <div className="grey-card pa-3 mb-2">
          <span className="profile-txt">মোট কমিশন</span>
          <p className="panel-blue-text mb-0">
            {dashboard?.summary.currency_symbol ?? '৳'}
            {dashboard?.summary.total_commission ?? '0.00'}
          </p>
        </div>
        <div className="grey-card pa-3 mb-2">
          <span className="profile-txt">মুলতুবি নিষ্পত্তি</span>
          <p className="mb-0">
            {dashboard?.summary.currency_symbol ?? '৳'}
            {dashboard?.summary.pending_settlement ?? '0.00'}
          </p>
        </div>
        <div className="grey-card pa-3">
          <span className="profile-txt">স্তর (সারিতে)</span>
          <p className="mb-0">{dashboard?.summary.tier_count ?? tierRows.length}</p>
        </div>
      </div>
    </div>
  )

  const reportRows = dashboard?.report.rows ?? []

  const reportBlock = (
    <div className="row px-4 no-gutters">
      <div className="col col-12">
        <p className="g-text">
          গত {dashboard?.report.period_days ?? 30} দিন · মোট {dashboard?.report.period_total ?? '0.00'}{' '}
          {dashboard?.report.currency_code ?? 'BDT'}
        </p>
        {reportRows.length === 0 ? (
          <p className="grey-text">এখনও কোনো রিপোর্ট সারি নেই।</p>
        ) : (
          <div className="table-responsive">
            <table className="w-full text-left" style={{ borderCollapse: 'collapse' }}>
              <thead>
                <tr className="referral-table-header">
                  <th className="pa-2">তারিখ</th>
                  <th className="pa-2">ভুক্তি</th>
                  <th className="pa-2">কমিশন</th>
                </tr>
              </thead>
              <tbody>
                {reportRows.map((r) => (
                  <tr key={r.date}>
                    <td className="pa-2">{r.date}</td>
                    <td className="pa-2">{r.entries}</td>
                    <td className="pa-2">{r.commission}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </div>
  )

  const historyRows = dashboard?.history.rows ?? []

  const historyBlock = (
    <div className="row px-4 no-gutters">
      <div className="col col-12">
        {historyRows.length === 0 ? (
          <p className="grey-text">কোনো ইতিহাস নেই।</p>
        ) : (
          <ul className="pl-0" style={{ listStyle: 'none' }}>
            {historyRows.map((h) => (
              <li key={h.id} className="grey-card pa-2 mb-2">
                <div className="d-flex justify-space-between">
                  <span>{h.title}</span>
                  <span className="font-weight-bold">{h.amount}</span>
                </div>
                <small className="g-text">{h.created_at}</small>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  )

  const desktopBody = () => {
    if (section === 'summary') return summaryBlock
    if (section === 'report') return reportBlock
    if (section === 'history') return historyBlock
    return null
  }

  const mobileTierTab = (
    <>
      <div className="row hidden-md-and-up">
        <div className="col col-12">
          <p>{descText}</p>
          <div className="row">
            <div className="text-left col col-12">
              <span>রেফারেল কোড :</span>
            </div>
            <div className="col col-12">
              <div className="referral-mobile-code-row">
                <div className="referral-code-cell">
                  <div className="referralCode-card text-center v-card v-sheet theme--light">
                    <div className="v-card__text">{referralCode}</div>
                    <span></span>
                  </div>
                </div>
                <button
                  type="button"
                  className="fill-height share-card referral-share-btn v-card v-card--link v-sheet theme--light"
                >
                  <span style={{ fontSize: '1.3rem' }}>SHARE</span>
                  <div
                    className="game-menu-image"
                    style={{ ['--src' as string]: "url('/static/svg/share.svg')" } as CSSProperties}
                  >
                    <img src="/static/svg/share.svg" className="side-menu-icon" alt="" />
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="row hidden-md-and-up">
        <div className="timeline-container col col">{tierTimeline('m')}</div>
      </div>
    </>
  )

  const mobileSummaryTab = <div className="hidden-md-and-up px-2">{summaryBlock}</div>

  return (
    <div className="margin-desktop my-12">
      <div className="referral-page">
        <div className="v-snack pa-0 v-snack--centered v-snack--has-background v-snack--top" style={{ paddingBottom: 0, paddingTop: 0 }}>
          <div className="v-snack__wrapper v-sheet theme--light" style={{ width: 'fit-content', display: 'none' }}>
            <div role="status" aria-live="polite" className="v-snack__content">
              <div role="alert" className="v-alert mb-0 pa-1 v-sheet theme--light profile-alert-failed" style={{ display: 'none' }}>
                <div className="v-alert__wrapper">
                  <i aria-hidden="true" className="v-icon notranslate v-alert__icon material-icons theme--light">
                    cancel
                  </i>
                  <div className="v-alert__content"></div>
                  <button type="button" className="v-alert__dismissible v-btn v-btn--icon v-btn--round theme--light v-size--small" aria-label="Close">
                    <span className="v-btn__content">
                      <i aria-hidden="true" className="v-icon notranslate material-icons theme--light">
                        close
                      </i>
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <div className="v-snack__action"></div>
          </div>
        </div>

        <div className="justify-space-around referralLayout hidden-sm-and-down v-card v-sheet theme--light elevation-0">
          <div className="v-image v-responsive theme--light">
            <div className="v-responsive__sizer" style={{ paddingBottom: '23.0769%' }}></div>
            <div
              className="v-image__image v-image__image--cover"
              style={{ backgroundImage: `url("${referralBannerCdn}")`, backgroundPosition: 'center center' }}
            ></div>
            <div className="v-responsive__content">
              <div className="fill-height">
                <div className="row fill-height no-gutters align-end justify-end">
                  <div className="col col-6">
                    <label className="ml-3 white--text">{titleBn}</label>
                    <p className="ml-3 white--text subtitle-2">{descText}</p>
                  </div>
                  <div className="text-right col col-12">
                    {tabs.map((tab) => (
                      <Link
                        key={tab.to}
                        to={tab.to}
                        className={`referral-tab v-btn v-btn--has-bg v-btn--router theme--light elevation-0 v-size--default${
                          normalizedPath === tab.to ? ' referral-tab--active v-btn--active' : ''
                        }`}
                      >
                        <span className="v-btn__content">{tab.labelDesktop}</span>
                      </Link>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="v-card__text referralContainer">
            <div className="referral-tier">
              <div className="hidden-sm-and-down">
                <div>
                  {desktopInnerBannerRow}
                  <div className="spacer"></div>
                  <div className="row px-4 pt-6">
                    <div className="col col-12">
                      <span className="referral-title">আজীবন রেফারেল কমিশন </span>
                    </div>
                  </div>
                </div>
                {section === 'tier' ? (
                  <div className="row px-4 no-gutters">
                    <div className="col col-12">{tierTimeline('dk')}</div>
                  </div>
                ) : (
                  desktopBody()
                )}
              </div>
            </div>
          </div>
        </div>

        <div className="justify-space-around referralLayout hidden-md-and-up v-card v-sheet theme--light elevation-0">
          <div className="v-image v-responsive theme--light">
            <div className="v-responsive__sizer" style={{ paddingBottom: '23.0769%' }}></div>
            <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
            <div className="v-responsive__content">
              <div className="row no-gutters justify-end">
                <div className="col col-12">
                  <div className="mobile-referral-expansion v-item-group theme--light v-expansion-panels v-expansion-panels--accordion v-expansion-panels--flat">
                    <div className="v-expansion-panel">
                      <button type="button" className="v-expansion-panel-header white--text">
                        <label className="white--text">{titleBn}</label>
                        <div className="v-expansion-panel-header__icon" aria-hidden>
                          <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-down theme--light"></i>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="row mobile-header no-gutters">
            <div className={`text-center mobile-header-item col col-6${normalizedPath === '/referral/tier' ? ' selected' : ''}`}>
              <Link to="/referral/tier" style={{ textDecoration: 'unset' }}>
                <span>আমার রেফারেল</span>
              </Link>
            </div>
            <div className={`text-center mobile-header-item col col-6${normalizedPath === '/referral/summary' ? ' selected' : ''}`}>
              <Link to="/referral/summary" style={{ textDecoration: 'unset' }}>
                <span>আমার কমিশন</span>
              </Link>
            </div>
          </div>

          <div className="v-card__text referralContainer">
            <div className="referral-tier">
              {mobileDuplicateHiddenSmDown}
              {normalizedPath === '/referral/summary' ? mobileSummaryTab : mobileTierTab}
              {(normalizedPath === '/referral/report' || normalizedPath === '/referral/history') && (
                <div className="hidden-md-and-up px-2">
                  {normalizedPath === '/referral/report' ? reportBlock : historyBlock}
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
