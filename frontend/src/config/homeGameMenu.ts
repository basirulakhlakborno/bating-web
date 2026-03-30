/** Mobile game tab strip from `bg-filter.blade.php` — maps to app routes. */
export type HomeGameMenuItem = {
  title: string
  holder: string
  icon: string
  to: string
  defaultSelected?: boolean
}

export const homeGameMenuItems: HomeGameMenuItem[] = [
  { title: 'জ্যাকপট', holder: '/static/svg/gameTabHolder/jackpot.svg', icon: '/static/svg/mobileMenu/homepageHot.png', to: '/promotion' },
  { title: 'হট', holder: '/static/svg/gameTabHolder/homepageHot.svg', icon: '/static/svg/mobileMenu/homepageHot.png', to: '/', defaultSelected: true },
  { title: 'স্লট', holder: '/static/svg/gameTabHolder/rng.svg', icon: '/static/svg/mobileMenu/rng.png', to: '/slot' },
  { title: 'ক্যাসিনো', holder: '/static/svg/gameTabHolder/ld.svg', icon: '/static/svg/mobileMenu/ld.png', to: '/casino' },
  { title: 'ক্র্যাশ', holder: '/static/svg/gameTabHolder/crash.svg', icon: '/static/svg/mobileMenu/crash.png', to: '/crash' },
  { title: 'ক্রিকেট', holder: '/static/svg/gameTabHolder/cricket.svg', icon: '/static/svg/mobileMenu/cricket.png', to: '/cricket' },
  { title: 'টেবিল', holder: '/static/svg/gameTabHolder/table.svg', icon: '/static/svg/mobileMenu/table.png', to: '/tablegames' },
  { title: 'ফাস্ট', holder: '/static/svg/gameTabHolder/fastgames.svg', icon: '/static/svg/mobileMenu/fastgames.png', to: '/fastgames' },
  { title: 'মাছ ধরা', holder: '/static/svg/gameTabHolder/fishing.svg', icon: '/static/svg/mobileMenu/fishing.png', to: '/fishing' },
  { title: 'এসবি', holder: '/static/svg/gameTabHolder/sb.svg', icon: '/static/svg/mobileMenu/sb.png', to: '/sportsbook' },
]
