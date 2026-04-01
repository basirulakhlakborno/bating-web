/// <reference types="vite/client" />

interface ImportMetaEnv {
  /** Laravel API origin; empty in production for same-origin paths. */
  readonly VITE_API_BASE_URL?: string
  /** Intercom widget app id (e.g. from Intercom → Settings → Installation). If unset, support does nothing. */
  readonly VITE_INTERCOM_APP_ID?: string
  /** Must match Laravel `PLAYER_EMAIL_DOMAIN` so cached users without `intercom_email` still omit synthetic emails. */
  readonly VITE_PLAYER_EMAIL_DOMAIN?: string
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}

interface Window {
  Intercom?: (...args: unknown[]) => void
  showToast?: (message: string, opts?: { type?: 'success' | 'error' | 'info'; duration?: number }) => void
  __babu88BootLoaderDone?: () => void
  babu88PushLoading?: () => void
  babu88PopLoading?: () => void
}
