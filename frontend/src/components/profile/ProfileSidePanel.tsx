import { Link } from 'react-router-dom'

const staticSvg = (name: string) => `https://babu88.gold/static/svg/${name}`

export type ProfileSidePanelProps = {
  memberCode: string
  bettingTierLabel: string
  bettingProgress: string
  vipLabel: string
  referralCode: string
  rewardCoins: string
  referralWallet: string
  /** Grid column classes; default profile 3/9 layout, bank pages use 2/8/2. */
  columnClassName?: string
}

const vipBadge = 'https://jiliwin.9terawolf.com/cms/h8/image/68c3cdb374fb9.png'

/** Shared left column for all `/profile/*` pages (desktop sidebar). */
const defaultSideCol =
  'bank-profile-side-panel hidden-sm-and-down mt-4 col col-12 col-md-3 col-lg-3'

export function ProfileSidePanel({
  memberCode,
  bettingTierLabel,
  bettingProgress,
  vipLabel,
  referralCode,
  rewardCoins,
  referralWallet,
  columnClassName = defaultSideCol,
}: ProfileSidePanelProps) {
  return (
    <div className={columnClassName}>
      <div style={{ height: '100%' }}>
        <div className="v-card v-sheet theme--light profile-side-vcard">
          <div className="row pa-4 desktop-left-panel no-gutters">
            <div className="col col-12 profile-welcome-block">
              <span className="profile-welcome-title">স্বাগতম!</span>
              <div className="grey-card profile-welcome-member-card">
                <div className="row pa-3 card-row no-gutters profile-welcome-card-row">
                  <img src={staticSvg('account-grey2.svg')} alt="" className="left-panel-icon mr-2" />
                  <span className="panel-blue-text">{memberCode}</span>
                </div>
              </div>
            </div>
            <div className="col col-12">
              <div className="grey-card">
                <div className="row pa-3 card-row no-gutters">
                  <div className="col col-12 profile-side-card-head">
                    <img src={staticSvg('bettingPass-grey.svg')} alt="" className="left-panel-icon profile-side-card-icon" />
                    <div className="profile-side-card-labels">
                      <span className="profile-side-line-title">বেটিং পাস</span>
                      <span className="panel-blue-text profile-side-line-value">{bettingTierLabel}</span>
                    </div>
                  </div>
                  <div className="mt-2 col col-12">
                    <div role="progressbar" className="v-progress-linear v-progress-linear--rounded theme--light" style={{ height: 4 }}>
                      <div className="v-progress-linear__background grey" style={{ opacity: 1, left: '0%', width: '100%' }}></div>
                      <div className="v-progress-linear__buffer"></div>
                      <div className="v-progress-linear__determinate yellow" style={{ width: '0%' }}></div>
                    </div>
                  </div>
                  <div className="mt-1 col col-12">
                    <span className="progress-text">{bettingProgress}</span>
                  </div>
                </div>
              </div>
            </div>
            <div className="col col-12">
              <div className="grey-card">
                <div className="row pa-3 card-row no-gutters">
                  <div className="col col-12 profile-side-card-head">
                    <img src={vipBadge} alt="" className="left-panel-icon profile-side-card-icon" />
                    <div className="profile-side-card-labels">
                      <span className="profile-side-line-title">VIP</span>
                      <span className="panel-blue-text profile-side-line-value profile-vip-member-label">{vipLabel}</span>
                    </div>
                  </div>
                  <div className="mt-2 col col-12">
                    <div role="progressbar" className="v-progress-linear v-progress-linear--rounded theme--light" style={{ height: 4 }}>
                      <div className="v-progress-linear__background grey" style={{ opacity: 1, left: '100%', width: '0%' }}></div>
                      <div className="v-progress-linear__buffer"></div>
                      <div className="v-progress-linear__determinate yellow" style={{ width: '100%' }}></div>
                    </div>
                  </div>
                  <div className="mt-1 col col-12">
                    <span className="progress-text profile-vip-detail-text">আমানত : সম্পন্ন</span>
                  </div>
                  <div className="mt-2 col col-12">
                    <div role="progressbar" className="v-progress-linear v-progress-linear--rounded theme--light" style={{ height: 4 }}>
                      <div className="v-progress-linear__background grey" style={{ opacity: 1, left: '0%', width: '100%' }}></div>
                      <div className="v-progress-linear__buffer"></div>
                      <div className="v-progress-linear__determinate yellow" style={{ width: '0%' }}></div>
                    </div>
                  </div>
                  <div className="mt-1 col col-12">
                    <span className="progress-text profile-vip-detail-text">টার্নওভার : 0/180,000</span>
                  </div>
                </div>
              </div>
            </div>
            <div className="col col-12">
              <hr role="separator" aria-orientation="horizontal" className="my-3 v-divider theme--light" />
            </div>
            <div className="col col-12">
              <div className="grey-card">
                <div className="row pa-3 card-row no-gutters">
                  <div className="g-text col col-12">
                    <span>পুরস্কারের কয়েন</span>
                  </div>
                  <div className="g-text col col-12">
                    <span className="panel-blue-text">{rewardCoins}</span>
                  </div>
                  <div className="mt-2 col col-12">
                    <Link to="/reward/rewardStore" className="nav-btn v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default text-decoration-none">
                      <span className="v-btn__content">পুরস্কার-এ যান</span>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
            <div className="col col-12">
              <div className="grey-card">
                <div className="row pa-3 card-row no-gutters">
                  <div className="g-text col col-12">
                    <span>রেফারেল ওয়ালেট</span>
                  </div>
                  <div className="g-text col col-12">
                    <span className="panel-blue-text">{referralWallet}</span>
                  </div>
                  <div className="mt-2 col col-12">
                    <button type="button" className="nav-btn v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default">
                      <span className="v-btn__content">রিডিম</span>
                    </button>
                  </div>
                  <div className="mt-2 col col-12">
                    <p className="profile-side-ref-hint">
                      আপনার রেফারেল কোড ব্যবহার করে সাইন আপ করার জন্য আপনার বন্ধুদের আমন্ত্রণ জানিয়ে আমাদের একচেটিয়া রেফারেল প্রোগ্রামের সাথে অতিরিক্ত নগদ উপার্জন করুন
                    </p>
                  </div>
                  <div className="mt-2 col col-12">
                    <div className="share-div">
                      <div className="referralCode-div">
                        <span className="grey-text-field ref-text panel-blue-text pa-2">{referralCode}</span>
                      </div>
                      <div className="share-btn-div">
                        <button type="button" className="share-btn v-btn v-btn--icon v-btn--round theme--light v-size--default" aria-label="শেয়ার">
                          <span className="v-btn__content">
                            <img src={staticSvg('share-outline.svg')} alt="" />
                          </span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
