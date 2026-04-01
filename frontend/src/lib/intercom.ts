import { show as intercomShow } from '@intercom/messenger-js-sdk'
import type { AuthUser } from './authFormFetch'

function syntheticPlayerEmailSuffix(): string {
  const raw = (import.meta.env.VITE_PLAYER_EMAIL_DOMAIN as string | undefined)?.trim()
  const host = (raw || 'players.local').replace(/^@/, '').toLowerCase()
  return `@${host}`
}

/**
 * Email to pass to Intercom. Omits synthetic `{username}@players.local` (and matches `config('auth.player_email_domain')` via `VITE_PLAYER_EMAIL_DOMAIN`).
 */
export function intercomIdentityEmail(user: AuthUser): string | undefined {
  if (user.intercom_email !== undefined && user.intercom_email !== null) {
    const v = String(user.intercom_email).trim()
    return v === '' ? undefined : v
  }
  const e = user.email?.trim()
  if (!e) return undefined
  if (e.toLowerCase().endsWith(syntheticPlayerEmailSuffix())) return undefined
  return e
}

function getAppId(): string | undefined {
  const id = import.meta.env.VITE_INTERCOM_APP_ID as string | undefined
  return id?.trim() || undefined
}

/**
 * Opens the Intercom messenger (custom launcher / drawer). Requires `IntercomBootstrap` + `VITE_INTERCOM_APP_ID`.
 */
export function openIntercomMessenger(): void {
  if (!getAppId()) return
  try {
    intercomShow()
  } catch {
    // Widget not ready or blocked
  }
}
