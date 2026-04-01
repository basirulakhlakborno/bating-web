import type { To } from 'react-router-dom'

export type BankProfileNavItem = { to: To; label: string }

/** Desktop bank/profile strip — only routes implemented in `App.tsx`. */
export const bankProfileNavItems: BankProfileNavItem[] = [
  { to: '/bank/deposit', label: 'আমানত' },
  { to: '/bank/withdrawal', label: 'উত্তোলন' },
  { to: '/bank/histories/transaction', label: 'ইতিহাস' },
  { to: '/profile/personal', label: 'আমার প্রোফাইল' },
  { to: '/profile/change-password', label: 'গোপন নম্বর' },
  { to: '/profile/inbox', label: 'ইনবক্স' },
  { to: '/profile/referral/tier', label: 'সুপারিশ' },
]
