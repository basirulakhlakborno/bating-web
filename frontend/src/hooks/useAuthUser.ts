import { useMemo, useSyncExternalStore } from 'react'
import {
  AUTH_CHANGED_EVENT,
  parseAuthUserJson,
  readAuthUserRaw,
  type AuthUser,
} from '../lib/authFormFetch'

/**
 * Re-renders when login/logout updates `babu88_auth_user`.
 * Uses a string snapshot so React does not see a new value every render (parsed objects are new references).
 */
export function useAuthUser(): AuthUser | null {
  const raw = useSyncExternalStore(
    (onStoreChange) => {
      window.addEventListener(AUTH_CHANGED_EVENT, onStoreChange)
      return () => window.removeEventListener(AUTH_CHANGED_EVENT, onStoreChange)
    },
    readAuthUserRaw,
    () => '',
  )
  return useMemo(() => parseAuthUserJson(raw), [raw])
}
