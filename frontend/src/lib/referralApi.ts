import { apiUrl } from '../config/apiBase'
import { readAuthToken } from './authFormFetch'

export type ReferralTierRow = {
  slug: string
  label: string
  rate_percent: number
  amount: string
  active: boolean
}

export type ReferralDashboard = {
  meta: {
    title_bn?: string
    description_bn: string
    referral_code: string
    share_url: string | null
  }
  tiers: ReferralTierRow[]
  summary: {
    currency_code: string
    currency_symbol: string
    total_commission: string
    total_bonus?: string
    total_referral_income?: string
    tier_count: number
    pending_settlement: string
    last_settled_at: string | null
  }
  report: {
    period_days: number
    currency_code: string
    rows: { date: string; entries: number; commission: string }[]
    period_total: string
  }
  history: {
    limit: number
    rows: {
      id: number
      source: string
      title: string
      amount: string
      currency_code: string
      occurred_on: string | null
      created_at: string | null
    }[]
  }
}

export async function fetchReferralDashboard(): Promise<{ ok: true; data: ReferralDashboard } | { ok: false; status: number; message: string }> {
  const token = readAuthToken()
  if (!token) {
    return { ok: false, status: 401, message: 'Unauthenticated.' }
  }
  const res = await fetch(apiUrl('/api/referral'), {
    method: 'GET',
    credentials: fetchCredentialsForUrl(apiUrl('/api/referral')),
    headers: {
      Accept: 'application/json',
      Authorization: `Bearer ${token}`,
    },
  })
  const data = (await res.json().catch(() => ({}))) as { message?: string } & ReferralDashboard
  if (!res.ok) {
    return { ok: false, status: res.status, message: (data as { message?: string }).message || 'Request failed.' }
  }
  return { ok: true, data: data as ReferralDashboard }
}

function fetchCredentialsForUrl(url: string): RequestCredentials {
  try {
    const resolved = new URL(url, window.location.href)
    return resolved.origin === window.location.origin ? 'same-origin' : 'include'
  } catch {
    return 'same-origin'
  }
}
