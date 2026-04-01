const staticSvg = (name: string) => `https://babu88.gold/static/svg/${name}`

export type ProfilePersonalMobileSummaryProps = {
  memberCode: string
  bettingTierLabel: string
  bettingProgress: string
  vipLabel: string
  referralCode: string
  rewardCoins: string
  referralWallet: string
}

/** Compact account strip on small screens — same placeholder data as desktop side panel. */
export function ProfilePersonalMobileSummary({
  memberCode,
  bettingTierLabel,
  bettingProgress,
  vipLabel,
  referralCode,
  rewardCoins,
  referralWallet,
}: ProfilePersonalMobileSummaryProps) {
  return (
    <div className="profile-mobile-summary hidden-md-and-up mt-3">
      <div className="v-card v-sheet theme--light profile-mobile-summary-card">
        <div className="profile-mobile-summary-grid">
          <div className="profile-mobile-summary-item">
            <img src={staticSvg('account-grey2.svg')} alt="" className="left-panel-icon" />
            <div>
              <div className="profile-mobile-summary-label">সদস্য</div>
              <div className="panel-blue-text profile-mobile-summary-value">{memberCode}</div>
            </div>
          </div>
          <div className="profile-mobile-summary-item">
            <span className="profile-mobile-summary-label">বেটিং পাস</span>
            <span className="panel-blue-text profile-mobile-summary-value">{bettingTierLabel}</span>
            <span className="profile-mobile-summary-sub">{bettingProgress}</span>
          </div>
          <div className="profile-mobile-summary-item">
            <span className="profile-mobile-summary-label">VIP</span>
            <span className="panel-blue-text profile-mobile-summary-value">{vipLabel}</span>
          </div>
        </div>
        <div className="profile-mobile-summary-row2">
          <div>
            <span className="profile-mobile-summary-label">পুরস্কারের কয়েন</span>
            <span className="panel-blue-text"> {rewardCoins}</span>
          </div>
        </div>
        <div className="profile-mobile-summary-row2">
          <div>
            <span className="profile-mobile-summary-label">রেফারেল</span>
            <span className="panel-blue-text"> {referralWallet}</span>
          </div>
          <span className="grey-text-field ref-text panel-blue-text pa-1 profile-mobile-refcode">{referralCode}</span>
        </div>
      </div>
    </div>
  )
}
