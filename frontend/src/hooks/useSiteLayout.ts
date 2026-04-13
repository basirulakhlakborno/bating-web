import { useEffect, useState } from 'react'
import { apiUrl } from '../config/apiBase'

interface FooterItem {
  id: number
  title: string
  subtitle: string | null
  image_path: string | null
  link_url: string | null
  sort_order: number
}

interface FooterSection {
  id: number
  slug: string
  title_bn: string
  sort_order: number
  items: FooterItem[]
}

interface SocialLink {
  id: number
  label: string
  icon_path: string | null
  url: string
  sort_order: number
}

interface PaymentMethod {
  id: number
  name: string
  image_path: string | null
  link_url: string | null
  alt: string | null
  sort_order: number
}

interface NavItem {
  id: number
  label_bn: string
  href: string
  sort_order: number
  icon_path: string | null
  label_class: string | null
  badge_variant: string | null
  has_badge_ui: boolean
  is_external: boolean
  drawer_meta_json: unknown
}

export interface FeaturedGame {
  id: number
  game_category_id: number | null
  title: string
  slug: string
  provider: string | null
  thumbnail_path: string | null
  href: string | null
  sort_order: number
  is_active: boolean
  is_featured: boolean
  category?: { id: number; slug: string; name_bn: string; name_en: string | null; sort_order: number } | null
}

export interface HomeMatchTeamRow {
  logo: string
  name: string
  score?: string
  overs?: string
}

export interface HomeMatchCard {
  id: number
  statusKind: 'live' | 'upcoming'
  inningsLabel?: string
  leagueName: string
  matchDate: string
  teams: [HomeMatchTeamRow, HomeMatchTeamRow]
  href?: string
}

interface SeoBlock {
  heading: string
  body: string
}

interface SeoExpandable {
  section_heading: string
  columns: SeoBlock[][]
}

export interface SiteLayout {
  layoutDesktopNav: NavItem[]
  layoutDrawerTop: NavItem[]
  layoutDrawerGames: NavItem[]
  layoutDrawerOthers: NavItem[]
  layoutFooterSections: FooterSection[]
  layoutPaymentMethods: PaymentMethod[]
  layoutSocialLinks: SocialLink[]
  layoutFeaturedGames: FeaturedGame[]
  layoutHomeMatches: HomeMatchCard[]
  layoutSiteBrandOfficialUrl: string
  layoutSiteHeaderLogoPath: string
  layoutSiteDrawerLogoPath: string
  layoutSiteBrandLogoPath: string
  layoutSiteBrandTagline: string
  layoutSiteCopyright: string
  layoutSiteHtmlTitle: string
  layoutSiteMetaDescription: string
  layoutSiteMetaKeywords: string
  layoutSiteOgImage: string
  layoutSiteLoaderAriaLabel: string
  layoutFooterSeoMain: { heading: string; intro: string }
  layoutFooterSeoExpandable: SeoExpandable
  intercomAppId: string
  layoutHomeReferralHeadlineEn: string
  layoutHomeReferralBodyBn: string
  layoutHomeReferralMobileSectionBn: string
  layoutHomeReferralMobileHeadlineEn: string
}

declare global {
  interface Window {
    __SITE_DATA__?: SiteLayout
  }
}

const injected = typeof window !== 'undefined' ? window.__SITE_DATA__ ?? null : null

let cachedData: SiteLayout | null = injected

/**
 * In production the Blade template injects `window.__SITE_DATA__` so the data
 * is available synchronously on first render (no flash, no loading state).
 * In Vite dev mode there's no Blade so we fall back to fetching `/api/site-layout`.
 */
export function useSiteLayout(): SiteLayout | null {
  const [data, setData] = useState<SiteLayout | null>(cachedData)

  useEffect(() => {
    if (cachedData) return

    fetch(apiUrl('/api/site-layout'), { headers: { Accept: 'application/json' } })
      .then((r) => (r.ok ? r.json() : null))
      .then((json: SiteLayout | null) => {
        if (json) {
          cachedData = json
          setData(json)
        }
      })
      .catch(() => {})
  }, [])

  return data
}
