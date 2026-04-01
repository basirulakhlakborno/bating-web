import { useCallback, useEffect, useMemo, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import type { ProfileSidePanelProps } from '../components/profile/ProfileSidePanel'
import { apiUrl } from '../config/apiBase'
import { bootstrapAuthUser, readAuthUser, type AuthUser } from './authFormFetch'
import { refreshPlayerUser } from './playerApi'

/**
 * Loads session + `/api/me` for profile/bank pages; redirects to login if unauthenticated.
 */
export function useProfileAuth() {
  const navigate = useNavigate()
  const [user, setUser] = useState<AuthUser | null>(() => readAuthUser())
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    let cancelled = false
    const load = async () => {
      window.babu88PushLoading?.()
      const origin = new URL(apiUrl('/'), window.location.href).origin
      await bootstrapAuthUser(origin)
      if (!cancelled) {
        const nextUser = readAuthUser()
        setUser(nextUser)
        setLoading(false)
        if (!nextUser) navigate('/login', { replace: true })
      }
      window.babu88PopLoading?.()
    }
    void load()
    return () => {
      cancelled = true
    }
  }, [navigate])

  const side = useMemo<ProfileSidePanelProps | null>(() => {
    if (!user) return null
    const symbol = user.currency_symbol || '৳'
    const balance = user.balance || '0.00'
    return {
      memberCode: user.username || '',
      bettingTierLabel: 'স্তর 1',
      bettingProgress: '0/200.00',
      vipLabel: 'MEMBER',
      referralCode: user.username || '',
      rewardCoins: '0',
      referralWallet: `${symbol} ${balance}`,
    }
  }, [user])

  const reloadUser = useCallback(async () => {
    const u = await refreshPlayerUser()
    setUser(u ?? readAuthUser())
  }, [])

  return { user, loading, side, reloadUser }
}
