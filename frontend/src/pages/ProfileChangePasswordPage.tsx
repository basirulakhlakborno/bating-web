import { ProfileChangePasswordMain } from '../components/profile/ProfileChangePasswordMain'
import { ProfilePageLayout } from '../components/profile/ProfilePageLayout'
import { useProfileAuth } from '../lib/useProfileAuth'

export function ProfileChangePasswordPage() {
  const { user, loading, side } = useProfileAuth()

  if (loading || !user || !side) return null

  return (
    <ProfilePageLayout side={side} wideMainColumn>
      <ProfileChangePasswordMain />
    </ProfilePageLayout>
  )
}
