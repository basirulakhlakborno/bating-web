import { useEffect } from 'react'
import { useLocation } from 'react-router-dom'

/** Scroll window to top on client-side navigation (SPA). */
export function ScrollToTop() {
  const { pathname, search, hash } = useLocation()

  useEffect(() => {
    window.scrollTo({ top: 0, left: 0, behavior: 'auto' })
  }, [pathname, search, hash])

  return null
}
