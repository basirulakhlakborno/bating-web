import { apiUrl } from '../config/apiBase'
import { readAuthToken, writeAuthUser, type AuthUser } from './authFormFetch'

function credentialsFor(url: string): RequestCredentials {
  try {
    const resolved = new URL(url, window.location.href)
    return resolved.origin === window.location.origin ? 'same-origin' : 'include'
  } catch {
    return 'same-origin'
  }
}

type ApiErrors = { message?: string; errors?: Record<string, string[]> }

export function flattenPlayerApiErrors(data: ApiErrors | null | undefined): string {
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

export async function playerJson<T extends object>(
  path: string,
  init: RequestInit = {},
): Promise<{ ok: boolean; status: number; data: T }> {
  const url = apiUrl(path)
  const token = readAuthToken()
  const headers = new Headers(init.headers)
  if (!headers.has('Accept')) headers.set('Accept', 'application/json')
  const body = init.body
  if (body && !(body instanceof FormData) && !headers.has('Content-Type')) {
    headers.set('Content-Type', 'application/json')
  }
  if (token) headers.set('Authorization', `Bearer ${token}`)

  const r = await fetch(url, {
    ...init,
    headers,
    credentials: credentialsFor(url),
  })
  const text = await r.text()
  let data = {} as T
  if (text) {
    try {
      data = JSON.parse(text) as T
    } catch {
      data = { message: text.slice(0, 200) } as T
    }
  }
  return { ok: r.ok, status: r.status, data }
}

export async function refreshPlayerUser(): Promise<AuthUser | null> {
  const { ok, data } = await playerJson<{ user?: AuthUser }>('/api/me', { method: 'GET' })
  if (!ok || !data?.user) return null
  writeAuthUser(data.user)
  return data.user
}
