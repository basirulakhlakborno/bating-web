/// <reference types="vite/client" />

interface ImportMetaEnv {
  /** Laravel API origin; empty in production for same-origin paths. */
  readonly VITE_API_BASE_URL?: string
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}

interface Window {
  Intercom?: (...args: unknown[]) => void
  showToast?: (message: string, opts?: { type?: 'success' | 'error' | 'info'; duration?: number }) => void
}
