import { ProfileChangePasswordMain } from '../components/profile/ProfileChangePasswordMain'
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

export function ProfileChangePasswordPage() {
  return (
    <ProfilePageLayout side={mockSide} wideMainColumn>
      <ProfileChangePasswordMain />
    </ProfilePageLayout>
  )
}
