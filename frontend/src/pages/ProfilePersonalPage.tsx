import { ProfilePageLayout } from '../components/profile/ProfilePageLayout'
import { ProfilePersonalMain, type ProfilePersonalFields } from '../components/profile/ProfilePersonalMain'

/** Placeholder profile — replace with API/session when auth is wired. */
const mockProfile: ProfilePersonalFields = {
  username: '—',
  currency: 'BDT',
  fullName: '',
  birthDate: '',
  email: '',
  phoneMasked: '+880 ******0000',
  street: '',
  city: '',
  subdistrict: '',
  district: '',
  postcode: '',
}

const mockSide = {
  memberCode: '—',
  bettingTierLabel: 'স্তর 1',
  bettingProgress: '0/200.00',
  vipLabel: 'MEMBER',
  referralCode: '—',
  rewardCoins: '0',
  referralWallet: '৳ 0.00',
}

export function ProfilePersonalPage() {
  return (
    <ProfilePageLayout side={mockSide}>
      <ProfilePersonalMain f={mockProfile} />
    </ProfilePageLayout>
  )
}
