import { Link } from 'react-router-dom'
import { useSiteLayout } from '../../hooks/useSiteLayout'

/** Referral / promo block from `bg-filter.blade.php` after matches. Copy is editable under Admin → Site settings → Home page. */
export function HomeReferralPromo() {
  const site = useSiteLayout()
  const headlineEn = site?.layoutHomeReferralHeadlineEn?.trim() || 'Refer friends and start earning'
  const bodyBn = site?.layoutHomeReferralBodyBn?.trim() || ''
  const mobileSectionBn = site?.layoutHomeReferralMobileSectionBn?.trim() || 'প্রচার'
  const mobileHeadlineEn = site?.layoutHomeReferralMobileHeadlineEn?.trim() || 'Refer and earn with BABU88'

  return (
    <div className="py-4">
      <div className="row mb-4 hidden-sm-and-down">
        <div className="col col-7">
          <div className="v-image v-responsive theme--light" style={{ borderRadius: 15 }}>
            <div className="v-responsive__sizer" style={{ paddingBottom: '28.5714%' }}></div>
            <div
              className="v-image__image v-image__image--cover"
              style={{
                backgroundImage: 'url("https://babu88.gold/static/image/homepage/refer_banner.jpg")',
                backgroundPosition: 'center center',
              }}
            ></div>
            <div className="v-responsive__content" style={{ width: 1400 }}>
              <div className="row pl-3 pt-3 no-gutters">
                <div className="d-flex align-center col col-12">
                  <div className="pa-0 col col-6">
                    <div className="row headerReferralText white--text no-gutters">{headlineEn}</div>
                    {bodyBn ? (
                      <div className="row descriptionReferralText white--text no-gutters home-referral-intro-bn">{bodyBn}</div>
                    ) : null}
                    <div className="row pt-3 referral-now-btn no-gutters">
                      <Link
                        to="/referralPreview"
                        className="referNowBtn v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none"
                        style={{ display: 'inline-flex' }}
                      >
                        <span className="v-btn__content">Refer Now</span>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="col col-5">
          <div className="v-image v-responsive theme--light" style={{ height: '100%', borderRadius: 12 }}>
            <div className="v-responsive__sizer" style={{ paddingBottom: '40%' }}></div>
            <div
              className="v-image__image v-image__image--cover"
              style={{
                backgroundImage: 'url("https://babu88.gold/static/image/homepage/bb88_bp_1400_560.jpg")',
                backgroundPosition: 'center center',
              }}
            ></div>
            <div className="v-responsive__content" style={{ width: 1400 }}></div>
          </div>
        </div>
      </div>

      <div className="row hidden-md-and-up font-weight-bold no-gutters align-end">{mobileSectionBn}</div>
      <div className="row mx-0 hidden-md-and-up no-gutters justify-center">
        <div className="pt-2 referral-banner col col-12">
          <div className="v-image v-responsive hidden-md-and-up banner-img theme--light">
            <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
            <div className="v-responsive__content"></div>
          </div>
        </div>
        <div className="pa-0 pt-3 col col-12">
          <span className="font-weight-bold">{mobileHeadlineEn}</span>
        </div>
        {bodyBn ? (
          <div className="pa-0 col col-12">
            <span className="referral_text home-referral-intro-bn">{bodyBn}</span>
          </div>
        ) : null}
        <div className="pa-0 pt-2 col col-12">
          <div className="v-image v-responsive theme--light" style={{ height: '100%', borderRadius: 12 }}>
            <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
            <div className="v-responsive__content"></div>
          </div>
        </div>
      </div>
    </div>
  )
}
