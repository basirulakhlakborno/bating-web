import { useCallback, useEffect, useState } from 'react'
import { AUTH_CHANGED_EVENT, readAuthToken } from './authFormFetch'
import { playerJson } from './playerApi'

export const INBOX_COUNT_REFRESH_EVENT = 'babu88-inbox-count-refresh'

type InboxPayload = {
  unread_count?: number
  messages?: unknown[]
  notices?: unknown[]
}

export function formatInboxBadgeCount(count: number): string {
  if (count < 1) return ''
  if (count > 99) return '99+'
  return String(count)
}

/** Unread / notification count from GET /api/inbox (`unread_count` or messages+notices length). */
export function useInboxUnreadCount(): number {
  const [count, setCount] = useState(0)

  const refresh = useCallback(async () => {
    const token = readAuthToken()
    if (!token) {
      setCount(0)
      return
    }
    const { ok, data } = await playerJson<InboxPayload>('/api/inbox', { method: 'GET' })
    if (!ok) {
      setCount(0)
      return
    }
    if (typeof data.unread_count === 'number' && Number.isFinite(data.unread_count)) {
      setCount(Math.max(0, Math.floor(data.unread_count)))
      return
    }
    const m = Array.isArray(data.messages) ? data.messages.length : 0
    const n = Array.isArray(data.notices) ? data.notices.length : 0
    setCount(Math.max(0, m + n))
  }, [])

  useEffect(() => {
    void refresh()
    const onAuth = () => void refresh()
    const onInbox = () => void refresh()
    const onFocus = () => void refresh()
    window.addEventListener(AUTH_CHANGED_EVENT, onAuth)
    window.addEventListener(INBOX_COUNT_REFRESH_EVENT, onInbox)
    window.addEventListener('focus', onFocus)
    return () => {
      window.removeEventListener(AUTH_CHANGED_EVENT, onAuth)
      window.removeEventListener(INBOX_COUNT_REFRESH_EVENT, onInbox)
      window.removeEventListener('focus', onFocus)
    }
  }, [refresh])

  return count
}
