import { useEffect, useReducer } from 'react'
import { AUTH_CHANGED_EVENT, readAuthUser, type AuthUser } from './authFormFetch'

/** Re-renders when auth storage changes (login/logout) so headers are not stuck on first paint. */
export function useAuthUserSnapshot(): AuthUser | null {
  const [, bump] = useReducer((x: number) => x + 1, 0)
  useEffect(() => {
    const onAuth = () => bump()
    window.addEventListener(AUTH_CHANGED_EVENT, onAuth)
    return () => window.removeEventListener(AUTH_CHANGED_EVENT, onAuth)
  }, [])
  return readAuthUser()
}
