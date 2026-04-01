/** Laravel CSRF: meta tag (Blade) or XSRF-TOKEN cookie (common SPA setups). */
export function readLaravelCsrf(): string {
  const meta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')
  const fromMeta = meta?.getAttribute('content')?.trim()
  if (fromMeta) return fromMeta

  const m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]*)/)
  if (m?.[1]) {
    try {
      return decodeURIComponent(m[1])
    } catch {
      return m[1]
    }
  }
  return ''
}
