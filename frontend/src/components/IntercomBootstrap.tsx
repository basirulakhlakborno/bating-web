import { Intercom } from '@intercom/messenger-js-sdk'
import { useEffect } from 'react'
import { useAuthUser } from '../hooks/useAuthUser'
import { useSiteLayout } from '../hooks/useSiteLayout'
import { intercomIdentityEmail } from '../lib/intercom'

/**
 * Client-side Intercom init (see `@intercom/messenger-js-sdk`).
 *
 * The app ID is read from `window.__SITE_DATA__.intercomAppId` (injected by
 * the Blade template from the database) with a fallback to
 * `VITE_INTERCOM_APP_ID` for local dev.
 *
 * `hide_default_launcher`: the floating support control is `#my_custom_link` in {@link GlobalOverlays}
 * (click handled there and in the nav drawer via `openIntercomMessenger`).
 */
export function IntercomBootstrap() {
  const user = useAuthUser()
  const layout = useSiteLayout()

  const appId =
    layout?.intercomAppId?.trim() ||
    (import.meta.env.VITE_INTERCOM_APP_ID as string | undefined)?.trim() ||
    undefined

  useEffect(() => {
    if (!appId) return

    const email = user ? intercomIdentityEmail(user) : undefined
    const payload: Parameters<typeof Intercom>[0] = {
      app_id: appId,
      hide_default_launcher: true,
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
  }, [appId, user])

  return null
}
