import { useMemo } from 'react'
import { ProfilePageLayout } from '../components/profile/ProfilePageLayout'
import { ProfilePersonalMain, type ProfilePersonalFields } from '../components/profile/ProfilePersonalMain'
import { useProfileAuth } from '../lib/useProfileAuth'
import type { AuthUser } from '../lib/authFormFetch'

function formatReferrerLine(user: AuthUser): string {
  const r = user.referrer
  if (!r) return ''
  const code = r.referral_code?.trim() ? ` · ${r.referral_code}` : ''
  return `${r.username}${code}`
}

function toProfileFields(user: AuthUser): ProfilePersonalFields {
  return {
    username: user.username || '',
    currency: user.currency_code || 'BDT',
    referrerLine: formatReferrerLine(user),
    fullName: (user.name && user.name.trim()) || user.username || '',
    birthDate: '',
    email: user.email || '',
    phoneMasked: user.phone || '',
    street: '',
    city: '',
    subdistrict: '',
    district: '',
    postcode: '',
  }
}

export function ProfilePersonalPage() {
  const { user, loading, side } = useProfileAuth()

  const dynamicProfile = useMemo(() => (user ? toProfileFields(user) : null), [user])

  if (loading || !user || !side || !dynamicProfile) return null

  return (
    <ProfilePageLayout side={side}>
      <ProfilePersonalMain f={dynamicProfile} />
    </ProfilePageLayout>
  )
}
