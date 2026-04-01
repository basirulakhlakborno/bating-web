import { BankHistoryMain } from '../components/bank/BankHistoryMain'
import { BankPageLayout, bankMainWideClass } from '../components/bank/BankPageLayout'
import { useProfileAuth } from '../lib/useProfileAuth'

export function BankHistoryPage() {
  const { user, loading, side } = useProfileAuth()

  if (loading || !user || !side) return null

  return (
    <BankPageLayout side={side} mainColumnClassName={bankMainWideClass}>
      <BankHistoryMain />
    </BankPageLayout>
  )
}
