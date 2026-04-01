import { readLaravelCsrf } from './csrf'

function fetchCredentialsForUrl(url: string): RequestCredentials {
  try {
    const resolved = new URL(url, window.location.href)
    return resolved.origin === window.location.origin ? 'same-origin' : 'include'
  } catch {
    return 'same-origin'
  }
}

type ApiErrorBody = {
  message?: string
  errors?: Record<string, string[]>
  token?: string
  token_type?: string
  expires_in?: number
  redirect?: string
}

type ParsedResponse = {
  ok: boolean
  status: number
  data: ApiErrorBody
}

const AUTH_TOKEN_KEY = 'babu88_auth_token'
const AUTH_USER_KEY = 'babu88_auth_user'

/** Fired after login/logout/user write so headers can re-read storage. */
export const AUTH_CHANGED_EVENT = 'babu88-auth-changed'

function notifyAuthChanged(): void {
  try {
    window.dispatchEvent(new CustomEvent(AUTH_CHANGED_EVENT))
  } catch {
    // ignore
  }
}

export type AuthReferrer = {
  id: number | string
  username: string
  referral_code: string
}

export type AuthUser = {
  id: number | string
  username: string
  /** Permanent shareable referral code (may differ from username). */
  referral_code?: string | null
  /** Account that referred this user, if any. */
  referrer?: AuthReferrer | null
  name?: string | null
  email?: string | null
  /** Real email for Intercom; null when `email` is synthetic `@{PLAYER_EMAIL_DOMAIN}`. */
  intercom_email?: string | null
  phone?: string | null
  currency_code?: string | null
  currency_symbol?: string | null
  balance?: string | null
  role?: string | null
  /** Account creation time (Unix seconds), from API — used by Intercom. */
  created_at?: number | null
}

export function readAuthToken(): string {
  try {
    return localStorage.getItem(AUTH_TOKEN_KEY) || ''
  } catch {
    return ''
  }
}

function writeAuthToken(token: string) {
  try {
    if (token) localStorage.setItem(AUTH_TOKEN_KEY, token)
  } catch {
    // ignore storage errors (private mode, quota)
  }
}

export function writeAuthUser(user: AuthUser | null | undefined) {
  try {
    if (user) localStorage.setItem(AUTH_USER_KEY, JSON.stringify(user))
  } catch {
    // ignore storage errors
  }
  notifyAuthChanged()
}

export function clearAuthStorage() {
  try {
    localStorage.removeItem(AUTH_TOKEN_KEY)
    localStorage.removeItem(AUTH_USER_KEY)
  } catch {
    // ignore storage errors
  }
  notifyAuthChanged()
}

export function parseAuthUserJson(raw: string): AuthUser | null {
  if (!raw) return null
  try {
    const parsed = JSON.parse(raw) as AuthUser
    if (!parsed || typeof parsed !== 'object') return null
    return parsed
  } catch {
    return null
  }
}

/** Raw JSON from storage — stable string for `useSyncExternalStore` snapshots. */
export function readAuthUserRaw(): string {
  try {
    return localStorage.getItem(AUTH_USER_KEY) ?? ''
  } catch {
    return ''
  }
}

export function readAuthUser(): AuthUser | null {
  return parseAuthUserJson(readAuthUserRaw())
}

function flattenErrors(data: ApiErrorBody | null | undefined): string {
  if (!data) return ''
  if (data.message && data.errors == null) return data.message
  if (data.errors && typeof data.errors === 'object') {
    const msgs: string[] = []
    for (const k of Object.keys(data.errors)) {
      const arr = data.errors[k]
      if (Array.isArray(arr)) arr.forEach((line) => msgs.push(line))
    }
    return msgs.join(' ') || data.message || ''
  }
  return data.message || ''
}

function syncCsrfIntoForm(form: HTMLFormElement) {
  const token = readLaravelCsrf()
  if (!token) return
  let input = form.querySelector<HTMLInputElement>('input[name="_token"]')
  if (!input) {
    input = document.createElement('input')
    input.type = 'hidden'
    input.name = '_token'
    form.prepend(input)
  }
  input.value = token
}

function showErr(errorId: string | undefined, text: string) {
  if (!errorId) return
  const errEl = document.getElementById(errorId)
  if (!errEl) return
  errEl.textContent = text || ''
  if (text) {
    errEl.removeAttribute('hidden')
    ;(errEl as HTMLElement).style.display = ''
  } else {
    errEl.setAttribute('hidden', '')
    ;(errEl as HTMLElement).style.display = 'none'
  }
}

function setSubmitsBusy(form: HTMLFormElement | null, on: boolean) {
  if (!form) return
  form.querySelectorAll<HTMLButtonElement | HTMLInputElement>('button[type="submit"], input[type="submit"]').forEach((btn) => {
    btn.disabled = on
    btn.setAttribute('aria-busy', on ? 'true' : 'false')
  })
}

async function ensureCsrfToken(actionUrl: string): Promise<void> {
  if (readLaravelCsrf()) return
  try {
    const target = new URL(actionUrl || '/', window.location.href)
    const csrfUrl = `${target.origin}/csrf-token`
    const res = await fetch(csrfUrl, {
      method: 'GET',
      headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: fetchCredentialsForUrl(csrfUrl),
    })
    if (!res.ok) return
    const json = (await res.json()) as { csrfToken?: string }
    if (!json?.csrfToken) return
    const meta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')
    if (meta) meta.setAttribute('content', json.csrfToken)
  } catch {
    // Fall back to cookie/meta if bootstrap endpoint is unavailable.
  }
}

async function postAuthMultipart(
  url: string,
  body: FormData,
  options: {
    errorId?: string
    successMessage?: string
    afterError?: (res: ParsedResponse, msg: string) => void
    formForBusy?: HTMLFormElement | null
  },
): Promise<void> {
  const { errorId, successMessage, afterError, formForBusy } = options

  try {
    const r = await fetch(url, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
        'X-CSRF-TOKEN': readLaravelCsrf(),
        ...(readAuthToken() ? { Authorization: `Bearer ${readAuthToken()}` } : {}),
      },
      body,
      credentials: fetchCredentialsForUrl(url),
    })

    const text = await r.text()
    let data: ApiErrorBody = {}
    if (text) {
      try {
        data = JSON.parse(text) as ApiErrorBody
      } catch {
        data = { message: text.slice(0, 200) }
      }
    }

    const res: ParsedResponse = { ok: r.ok, status: r.status, data }

    if (res.status === 419) {
      const csrfMsg = 'সেশন মেয়াদ শেষ হয়েছে। অনুগ্রহ করে আবার লগইন করুন।'
      showErr(errorId, csrfMsg)
      window.showToast?.(csrfMsg, { type: 'error' })
      afterError?.(res, 'csrf')
      return
    }

    const payload = res.data
    if (res.ok) {
      if (payload.token) writeAuthToken(payload.token)
      if ((payload as { user?: AuthUser }).user) writeAuthUser((payload as { user?: AuthUser }).user)
      const okText = successMessage || payload.message || 'সফল হয়েছে।'
      if (okText) window.showToast?.(okText, { type: 'success' })
      window.setTimeout(
        () => {
          window.location.assign('/')
        },
        okText ? 550 : 0,
      )
      return
    }

    const msg = flattenErrors(res.data) || 'অনুরোধ সম্পূর্ণ হয়নি।'
    showErr(errorId, msg)
    window.showToast?.(msg, { type: 'error' })
    afterError?.(res, msg)
  } catch {
    const netMsg = 'নেটওয়ার্ক ত্রুটি। অনুগ্রহ করে আবার চেষ্টা করুন।'
    showErr(errorId, netMsg)
    window.showToast?.(netMsg, { type: 'error' })
    afterError?.({ ok: false, status: 0, data: {} }, 'network')
  } finally {
    setSubmitsBusy(formForBusy ?? null, false)
    window.babu88PopLoading?.()
  }
}

export async function bootstrapAuthUser(apiBaseUrl: string): Promise<void> {
  const token = readAuthToken()
  if (!token) {
    clearAuthStorage()
    return
  }
  try {
    const meUrl = new URL('/api/me', apiBaseUrl || window.location.origin).toString()
    const r = await fetch(meUrl, {
      method: 'GET',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`,
      },
      credentials: fetchCredentialsForUrl(meUrl),
    })
    if (!r.ok) {
      clearAuthStorage()
      return
    }
    const data = (await r.json()) as { user?: AuthUser }
    if (!data?.user) {
      clearAuthStorage()
      return
    }
    writeAuthUser(data.user)
  } catch {
    // Keep existing token/user on network failure to avoid false logout.
  }
}

/** Login only: JSON/AJAX POST — never relies on a real form `action` (no full-page POST). */
export async function submitLoginAjax(opts: {
  url: string
  username: string
  password: string
  errorId?: string
  successMessage?: string
  formForBusy?: HTMLFormElement | null
}): Promise<void> {
  const { url, username, password, errorId, successMessage, formForBusy } = opts

  showErr(errorId, '')
  await ensureCsrfToken(url)

  const token = readLaravelCsrf()
  const fd = new FormData()
  if (token) fd.set('_token', token)
  fd.set('username', username)
  fd.set('password', password)

  setSubmitsBusy(formForBusy ?? null, true)
  window.babu88PushLoading?.()

  await postAuthMultipart(url, fd, { errorId, successMessage, formForBusy })
}

/** Register and other form-encoded flows built from a live `<form>` element. */
export async function submitAuthForm(
  form: HTMLFormElement,
  options: {
    errorId?: string
    successMessage?: string
    beforeFetch?: (form: HTMLFormElement) => false | void
    afterError?: (res: ParsedResponse, msg: string) => void
  },
): Promise<void> {
  const { errorId, successMessage, beforeFetch, afterError } = options

  showErr(errorId, '')
  if (typeof beforeFetch === 'function' && beforeFetch(form) === false) return
  await ensureCsrfToken(form.getAttribute('action') || '')

  syncCsrfIntoForm(form)
  setSubmitsBusy(form, true)
  window.babu88PushLoading?.()

  const action = form.getAttribute('action') || ''
  const fd = new FormData(form)

  await postAuthMultipart(action, fd, { errorId, successMessage, afterError, formForBusy: form })
}
