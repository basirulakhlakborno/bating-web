/** Normalize admin-entered paths (leading slash, trim). */
export function normalizeInternalNavHref(href: string): string {
  const h = href.trim()
  if (!h || h.startsWith('http://') || h.startsWith('https://')) {
    return h
  }
  return h.startsWith('/') ? h : `/${h}`
}
