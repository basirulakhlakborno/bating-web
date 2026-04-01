import { Intercom } from '@intercom/messenger-js-sdk'
import { useAuthUser } from '../hooks/useAuthUser'
import { intercomIdentityEmail } from '../lib/intercom'

function getAppId(): string | undefined {
  const id = import.meta.env.VITE_INTERCOM_APP_ID as string | undefined
  return id?.trim() || undefined
}

/**
 * Client-side Intercom init (see `@intercom/messenger-js-sdk`).
 * Use named `{ Intercom }` import — CJS default interop under Vite can make default import non-callable.
 */
export function IntercomBootstrap() {
  const user = useAuthUser()
  const appId = getAppId()
  if (!appId) return null

  const email = user ? intercomIdentityEmail(user) : undefined

  const payload: Parameters<typeof Intercom>[0] = {
    app_id: appId,
    ...(user && {
      user_id: String(user.id),
      name: (user.name ?? user.username) || undefined,
      ...(email ? { email } : {}),
      ...(typeof user.created_at === 'number' && user.created_at > 0
        ? { created_at: user.created_at }
        : {}),
    }),
  }

  Intercom(payload)
  return null
}
