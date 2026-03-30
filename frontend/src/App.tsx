import { BrowserRouter, Route, Routes } from 'react-router-dom'
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

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/*" element={<Babu88Layout />}>
          <Route index element={<HomePage />} />
          <Route path="login" element={<LoginPage />} />
          <Route path="register" element={<RegisterPage />} />
          <Route path="profile/personal" element={<ProfilePersonalPage />} />
          <Route path="profile/inbox" element={<ProfileInboxPage />} />
          <Route path="profile/change-password" element={<ProfileChangePasswordPage />} />
          <Route path="bank/deposit" element={<BankDepositPage />} />
          <Route path="bank/histories/transaction" element={<BankHistoryPage />} />
          <Route path="bank/withdrawal" element={<BankWithdrawalPage />} />
          <Route path="*" element={<NavPage />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}
