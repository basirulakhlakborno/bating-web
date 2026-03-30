/**
 * Laravel backend base URL for API/form/captcha calls from the Vite app.
 * - Development: set `VITE_API_BASE_URL` in `.env.development` (e.g. `http://localhost` or `http://127.0.0.1:8000`).
 * - Production: leave empty or use `""` so requests use the same origin (paths from `/`).
 */
export function getApiBase(): string {
  const raw = import.meta.env.VITE_API_BASE_URL
  if (raw !== undefined && String(raw).trim() !== '') {
    return String(raw).replace(/\/$/, '')
  }
  if (import.meta.env.PROD) {
    return ''
  }
  return 'http://localhost'
}

/** Join base + path; path must start with `/`. */
export function apiUrl(path: string): string {
  const p = path.startsWith('/') ? path : `/${path}`
  const base = getApiBase()
  if (!base) return p
  return `${base}${p}`
}
