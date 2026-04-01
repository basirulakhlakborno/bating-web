import { useEffect, useState } from 'react'
import { ProfileInboxMain, type InboxMessage } from '../components/profile/ProfileInboxMain'
import { ProfilePageLayout } from '../components/profile/ProfilePageLayout'
import { playerJson } from '../lib/playerApi'
import { INBOX_COUNT_REFRESH_EVENT } from '../lib/useInboxUnreadCount'
import { useProfileAuth } from '../lib/useProfileAuth'

type InboxApiRow = {
  id?: string | number
  title?: string
  body?: string
  created_at?: string
}

export function ProfileInboxPage() {
  const { user, loading, side } = useProfileAuth()
  const [messages, setMessages] = useState<InboxMessage[]>([])

  useEffect(() => {
    if (!user) return
    let cancelled = false
    const load = async () => {
      const { ok, data } = await playerJson<{ messages?: InboxApiRow[] }>('/api/inbox', { method: 'GET' })
      if (cancelled) return
      if (!ok) {
        setMessages([])
        return
      }
      if (!data?.messages?.length) {
        if (!cancelled) {
          setMessages([])
          window.dispatchEvent(new CustomEvent(INBOX_COUNT_REFRESH_EVENT))
        }
        return
      }
      const mapped: InboxMessage[] = data.messages.map((m, i) => {
        const id = String(m.id ?? i)
        const created = m.created_at ? new Date(m.created_at) : new Date()
        return {
          id,
          title: m.title || m.body || 'বার্তা',
          date: created.toISOString().slice(0, 10),
          time: created.toTimeString().slice(0, 5),
        }
      })
      setMessages(mapped)
      window.dispatchEvent(new CustomEvent(INBOX_COUNT_REFRESH_EVENT))
    }
    void load()
    return () => {
      cancelled = true
    }
  }, [user])

  if (loading || !user || !side) return null

  return (
    <ProfilePageLayout side={side}>
      <ProfileInboxMain messages={messages} />
    </ProfilePageLayout>
  )
}
