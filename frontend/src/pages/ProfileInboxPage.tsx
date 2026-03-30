import { ProfileInboxMain } from '../components/profile/ProfileInboxMain'
import { ProfilePageLayout } from '../components/profile/ProfilePageLayout'

const mockSide = {
  memberCode: '—',
  bettingTierLabel: 'স্তর 1',
  bettingProgress: '0/200.00',
  vipLabel: 'MEMBER',
  referralCode: '—',
  rewardCoins: '0',
  referralWallet: '৳ 0.00',
}

export function ProfileInboxPage() {
  return (
    <ProfilePageLayout side={mockSide}>
      <ProfileInboxMain />
    </ProfilePageLayout>
  )
}
