import { BankDepositMain } from '../components/bank/BankDepositMain'
import { BankDepositMobileHeader } from '../components/bank/BankDepositMobileHeader'
import { BankDepositNotices } from '../components/bank/BankDepositNotices'
import { BankPageLayout } from '../components/bank/BankPageLayout'
import { useProfileAuth } from '../lib/useProfileAuth'

export function BankDepositPage() {
  const { user, loading, side, reloadUser } = useProfileAuth()

  if (loading || !user || !side) return null

  return (
    <BankPageLayout side={side} rightRail={<BankDepositNotices />}>
      <BankDepositMobileHeader />
      <BankDepositMain onDepositSuccess={reloadUser} />
    </BankPageLayout>
  )
}
