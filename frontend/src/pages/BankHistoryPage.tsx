import { BankHistoryMain } from '../components/bank/BankHistoryMain'
import { BankPageLayout, bankMainWideClass } from '../components/bank/BankPageLayout'
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

export function BankHistoryPage() {
  return (
    <BankPageLayout side={mockSide} mainColumnClassName={bankMainWideClass}>
      <BankHistoryMain />
    </BankPageLayout>
  )
}
