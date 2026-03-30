import type { To } from 'react-router-dom'

export type BankProfileNavItem = { to: To; label: string }

/** Desktop bank/profile strip from legacy `bankPage-navigationBar`. */
export const bankProfileNavItems: BankProfileNavItem[] = [
  { to: '/bank/deposit', label: 'আমানত' },
  { to: '/bank/withdrawal', label: 'উত্তোলন' },
  { to: '/bank/voucher', label: 'ভাউচার' },
  { to: '/bank/histories/transaction', label: 'ইতিহাস' },
  { to: '/profile/personal', label: 'আমার প্রোফাইল' },
  { to: '/profile/bank-account', label: 'ব্যাংক বিবরণ' },
  { to: '/profile/change-password', label: 'গোপন নম্বর' },
  { to: '/profile/inbox', label: 'ইনবক্স' },
  { to: '/profile/referral/tier', label: 'সুপারিশ' },
  { to: '/viptiers/vip-tier', label: 'বেটিং পাস' },
  { to: '/luckywheel', label: 'হুইল অফ ফরচুন' },
  { to: '/reward/rewardStore', label: 'পুরস্কার' },
]
