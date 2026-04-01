import { StrictMode, useEffect, useState } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import './styles/babu88-shell.css'
import App from './App.tsx'
import { apiUrl } from './config/apiBase'
import { bootstrapAuthUser } from './lib/authFormFetch'

function AppRoot() {
  const [bootReady, setBootReady] = useState(false)

  useEffect(() => {
    const boot = async () => {
      const origin = new URL(apiUrl('/'), window.location.href).origin
      const timeoutMs = 12000
      await Promise.race([
        bootstrapAuthUser(origin),
        new Promise<void>((resolve) => window.setTimeout(resolve, timeoutMs)),
      ])
      setBootReady(true)
      window.__babu88BootLoaderDone?.()
    }
    void boot()
  }, [])

  if (!bootReady) return null

  return (
    <StrictMode>
      <App />
    </StrictMode>
  )
}

createRoot(document.getElementById('root')!).render(<AppRoot />)
