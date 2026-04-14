import { useEffect, useMemo, useRef } from 'react'
import { useParams } from 'react-router-dom'
import { apiUrl } from '../config/apiBase'
import { readAuthToken } from '../lib/authFormFetch'

/**
 * In-app game view: React keeps the Babu88 shell; Laravel iframe-shell loads the remote game (bridge + token).
 */
export function GamePlayPage() {
  const { gameId } = useParams()
  const frameRef = useRef<HTMLIFrameElement>(null)

  const iframeSrc = useMemo(() => {
    const id = gameId?.trim() ?? ''
    if (!/^\d+$/.test(id)) {
      return ''
    }
    const shell = apiUrl(`/games/iframe-shell/${id}`)
    const token = typeof localStorage !== 'undefined' ? localStorage.getItem('babu88_auth_token')?.trim() ?? '' : ''
    if (!token) {
      return shell
    }
    const sep = shell.includes('?') ? '&' : '?'
    return `${shell}${sep}token=${encodeURIComponent(token)}`
  }, [gameId])

  /** Cross-origin shell (e.g. Vite :5173 parent, Laravel iframe) cannot read this origin's token from localStorage; postMessage supplies it. */
  useEffect(() => {
    if (!iframeSrc) return
    const token = readAuthToken().trim()
    if (!token) return
    const el = frameRef.current
    if (!el) return
    const send = () => {
      try {
        el.contentWindow?.postMessage({ type: 'babu88-bridge-token', token }, '*')
      } catch {
        // ignore
      }
    }
    el.addEventListener('load', send)
    const t = window.setTimeout(send, 0)
    return () => {
      el.removeEventListener('load', send)
      window.clearTimeout(t)
    }
  }, [iframeSrc])

  if (!iframeSrc) {
    return (
      <div className="auth-page-main py-8 px-5 text-center">
        <p className="login-header-desc">Invalid game link.</p>
      </div>
    )
  }

  return (
    <div
      className="game-play-embed-root"
      style={{
        width: '100%',
        background: '#0d1117',
      }}
    >
      <iframe
        ref={frameRef}
        title="Game"
        src={iframeSrc}
        allow="fullscreen"
        loading="eager"
        style={{
          width: '100%',
          height: '80vh',
          border: 0,
          display: 'block',
          background: '#000',
        }}
      />
    </div>
  )
}
