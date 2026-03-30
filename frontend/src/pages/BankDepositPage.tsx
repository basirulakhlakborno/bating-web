import { BankDepositMain } from '../components/bank/BankDepositMain'
import { BankDepositMobileHeader } from '../components/bank/BankDepositMobileHeader'
import { BankDepositNotices } from '../components/bank/BankDepositNotices'
import { BankPageLayout } from '../components/bank/BankPageLayout'
import type { ProfileSidePanelProps } from '../components/profile/ProfileSidePanel'

const mockSide: ProfileSidePanelProps = {
  memberCode: '—',
  bettingTierLabel: 'স্তর 1',
  bettingProgress: '0/200.00',
  vipLabel: 'MEMBER',
  referralCode: '—',
  rewardCoins: '0',
  referralWallet: '৳ 0.00',
}

export function BankDepositPage() {
  return (
    <BankPageLayout side={mockSide} rightRail={<BankDepositNotices />}>
      <BankDepositMobileHeader />
      <BankDepositMain />
    </BankPageLayout>
  )
}
