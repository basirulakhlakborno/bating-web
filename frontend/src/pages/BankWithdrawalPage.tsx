import { BankDepositMobileHeader } from '../components/bank/BankDepositMobileHeader'
import { BankDepositNotices } from '../components/bank/BankDepositNotices'
import { BankPageLayout } from '../components/bank/BankPageLayout'
import { BankWithdrawalMain } from '../components/bank/BankWithdrawalMain'
import { useProfileAuth } from '../lib/useProfileAuth'

export function BankWithdrawalPage() {
  const { user, loading, side, reloadUser } = useProfileAuth()

  if (loading || !user || !side) return null

  return (
    <BankPageLayout side={side} rightRail={<BankDepositNotices />}>
      <BankDepositMobileHeader />
      <BankWithdrawalMain user={user} onBalanceRefresh={reloadUser} />
    </BankPageLayout>
  )
}
