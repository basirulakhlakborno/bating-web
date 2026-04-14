import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { ScrollToTop } from './components/ScrollToTop'
import { Babu88Layout } from './layouts/Babu88Layout'
import { HomePage } from './pages/HomePage'
import { LoginPage } from './pages/LoginPage'
import { NavPage } from './pages/NavPage'
import { RegisterPage } from './pages/RegisterPage'
import { BankDepositPage } from './pages/BankDepositPage'
import { BankHistoryPage } from './pages/BankHistoryPage'
import { BankWithdrawalPage } from './pages/BankWithdrawalPage'
import { ProfileChangePasswordPage } from './pages/ProfileChangePasswordPage'
import { ProfileInboxPage } from './pages/ProfileInboxPage'
import { ProfilePersonalPage } from './pages/ProfilePersonalPage'
import { ReferralPage } from './pages/ReferralPage'
import { GamePlayPage } from './pages/GamePlayPage'

export default function App() {
  return (
    <BrowserRouter>
      <ScrollToTop />
      <Routes>
        <Route element={<Babu88Layout />}>
          <Route index element={<HomePage />} />
          <Route path="login" element={<LoginPage />} />
          <Route path="register" element={<RegisterPage />} />
          <Route path="profileAccount" element={<ProfilePersonalPage />} />
          <Route path="profile/personal" element={<ProfilePersonalPage />} />
          <Route path="profile/inbox" element={<ProfileInboxPage />} />
          <Route path="profile/change-password" element={<ProfileChangePasswordPage />} />
          <Route path="bank/deposit" element={<BankDepositPage />} />
          <Route path="bank/histories/transaction" element={<BankHistoryPage />} />
          <Route path="bank/withdrawal" element={<BankWithdrawalPage />} />
          <Route path="promotion" element={<NavPage />} />
          <Route path="referralPreview" element={<NavPage />} />
          <Route path="referral/tier" element={<ReferralPage />} />
          <Route path="referral/summary" element={<ReferralPage />} />
          <Route path="referral/report" element={<ReferralPage />} />
          <Route path="referral/history" element={<ReferralPage />} />
          <Route path="profile/referral/tier" element={<ReferralPage />} />
          <Route path="profile/referral/summary" element={<ReferralPage />} />
          <Route path="profile/referral/report" element={<ReferralPage />} />
          <Route path="profile/referral/history" element={<ReferralPage />} />
          <Route path="vip/vipProfile" element={<NavPage />} />
          <Route path="reward/rewardStore" element={<NavPage />} />
          <Route path="games/play/:gameId" element={<GamePlayPage />} />
          <Route path="*" element={<NavPage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}
