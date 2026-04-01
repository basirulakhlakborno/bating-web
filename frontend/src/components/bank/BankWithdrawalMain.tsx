import { useEffect, useState } from 'react'
import type { AuthUser } from '../../lib/authFormFetch'
import { readAuthUser } from '../../lib/authFormFetch'
import { flattenPlayerApiErrors, playerJson, refreshPlayerUser } from '../../lib/playerApi'

const staticSvg = (name: string) => `https://babu88.gold/static/svg/${name}`
const warnIcon = staticSvg('personal-info-warning.svg')

const METHODS = [
  { id: 'BKASH' as const, src: 'deposit-ewallet-bkash.svg' },
  { id: 'NAGAD' as const, src: 'deposit-ewallet-nagad.svg' },
]

function ReloadIcon() {
  return (
    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden>
      <path d="M17.65 6.35A7.958 7.958 0 0012 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0112 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" />
    </svg>
  )
}

function HelpIcon() {
  return (
    <span className="depo-help-icon" aria-hidden>
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
      </svg>
    </span>
  )
}

export function BankWithdrawalMain({
  user,
  onBalanceRefresh,
}: {
  user: AuthUser
  onBalanceRefresh?: () => void | Promise<void>
}) {
  const symbol = user.currency_symbol || '৳'
  const [method, setMethod] = useState<(typeof METHODS)[number]['id']>('BKASH')
  const [phone, setPhone] = useState(user.phone || '')
  const [amount, setAmount] = useState('')
  const [balance, setBalance] = useState(`${symbol} ${user.balance || '0.00'}`)
  const [busy, setBusy] = useState(false)

  useEffect(() => {
    setPhone(user.phone || '')
  }, [user.phone])

  useEffect(() => {
    setBalance(`${symbol} ${user.balance || '0.00'}`)
  }, [user.balance, symbol])

  const submitDisabled = busy || !phone.trim() || !amount.trim()

  const refreshBalance = async () => {
    window.babu88PushLoading?.()
    try {
      await refreshPlayerUser()
      await onBalanceRefresh?.()
      const u = readAuthUser()
      if (u) setBalance(`${u.currency_symbol || symbol} ${u.balance || '0.00'}`)
    } finally {
      window.babu88PopLoading?.()
    }
  }

  return (
    <div className="v-card v-sheet theme--light desktop_withdraw_card bank-withdraw-card">
      <div className="v-card__title hidden-sm-and-down pl-3 ml-7 bank-withdraw-title-row">
        <label className="--v-primary-base withdraw-desktop-txt text-left text-capitalize">উত্তোলন</label>
      </div>

      <div className="hidden-md-and-up mobile-balance-card v-card v-sheet theme--light">
        <div className="mobile-balance-div">
          <div>
            <span className="mobile-balance-label">ভারসাম্য</span>
            <button type="button" className="bank-withdraw-reload-btn" aria-label="রিফ্রেশ" onClick={() => void refreshBalance()}>
              <ReloadIcon />
            </button>
          </div>
          <div>
            <span className="mobile-balance-value">{balance}</span>
          </div>
        </div>
      </div>

      <div className="bank-detail-card phoneVerificationAlert v-card v-sheet theme--light">
        <div className="row section-container no-gutters">
          <div className="d-flex align-center phone-verify-inner">
            <div
              className="v-image v-responsive theme--light bank-withdraw-warn-icon"
              style={{ height: 25, width: 25 }}
              role="img"
              aria-hidden
            >
              <div
                className="bank-withdraw-warn-bg"
                style={{ backgroundImage: `url("${warnIcon}")` }}
              />
            </div>
            <label className="px-2 phone-verify-msg">
              ফোন নম্বর যাচাই করা হয়নি, উত্তোলন করার আগে দয়া করে যাচাই করে নিন।
            </label>
            <button type="button" className="link-underscore warning-text phone-verify-link">
              যাচাই করুন
            </button>
          </div>
        </div>
      </div>

      <div className="bank-detail-card deposit-card v-card v-sheet theme--light elevation-0">
        <form
          className="v-form bank-withdraw-form"
          noValidate
          onSubmit={async (e) => {
            e.preventDefault()
            if (submitDisabled) return
            const raw = amount.replace(/[^\d.]/g, '')
            const num = parseFloat(raw)
            if (!Number.isFinite(num) || num < 500) {
              window.showToast?.('ন্যূনতম ৳ 500।', { type: 'error' })
              return
            }
            if (num > 30000) {
              window.showToast?.('সর্বোচ্চ ৳ 30,000।', { type: 'error' })
              return
            }
            const reference = `wd-${Date.now()}-${Math.random().toString(36).slice(2, 12)}`
            setBusy(true)
            window.babu88PushLoading?.()
            try {
              const { ok, data } = await playerJson<{ message?: string; balance?: string }>('/api/bank/withdraw', {
                method: 'POST',
                body: JSON.stringify({
                  amount: num.toFixed(2),
                  currency_code: user.currency_code || 'BDT',
                  method,
                  account_phone: phone.trim(),
                  reference,
                }),
              })
              if (ok) {
                window.showToast?.(data.message || 'উত্তোলন সম্পন্ন।', { type: 'success' })
                setAmount('')
                await refreshPlayerUser()
                await onBalanceRefresh?.()
                const u = readAuthUser()
                if (u) setBalance(`${u.currency_symbol || symbol} ${u.balance || '0.00'}`)
              } else {
                const msg = flattenPlayerApiErrors(data as { message?: string; errors?: Record<string, string[]> }) || 'অনুরোধ সম্পূর্ণ হয়নি।'
                window.showToast?.(msg, { type: 'error' })
              }
            } finally {
              setBusy(false)
              window.babu88PopLoading?.()
            }
          }}
        >
          <div className="row hidden-sm-and-down no-gutters align-end">
            <div className="col-md-8 col">
              <label className="input-field-label ma-0 text-capitalize d-block pb-2">
                উত্তোলনের বিকল্প
                <span className="red--text ml-1">*</span>
              </label>
              <div className="row py-2 no-gutters bank-withdraw-method-row">
                {METHODS.map((m) => (
                  <div key={m.id} className="col col-auto">
                    <button
                      type="button"
                      value={m.id}
                      onClick={() => setMethod(m.id)}
                      className={`v-btn v-btn--outlined theme--light v-size--default mr-4 pa-2 gateway-button bank-withdraw-gateway${
                        method === m.id ? ' active-gateway-button v-btn--active' : ''
                      }`}
                      style={{ height: '100%', minWidth: 90 }}
                    >
                      <span className="v-btn__content">
                        <div className="row no-gutters bank-withdraw-gateway-inner">
                          <div className="pt-1 pb-0 col">
                            <img src={staticSvg(m.src)} alt="" />
                          </div>
                        </div>
                      </span>
                    </button>
                  </div>
                ))}
              </div>
            </div>
          </div>

          <div className="row pt-4 hidden-sm-and-down no-gutters align-end">
            <div className="col col-12">
              <label className="input-field-label ma-0 text-capitalize d-block pb-2">
                মোবাইল নম্বর
                <span className="red--text ml-1">*</span>
              </label>
            </div>
            <div className="col-md-6 col">
              <div className="v-input withdraw-box v-input--dense theme--light v-text-field v-text-field--enclosed v-text-field--outlined">
                <div className="v-input__control">
                  <div className="v-input__slot depo-input-slot bank-withdraw-select-slot">
                    <input
                      id="withdraw-phone-desktop"
                      className="bank-withdraw-native-select"
                      type="tel"
                      inputMode="numeric"
                      autoComplete="tel"
                      placeholder="মোবাইল নম্বর"
                      value={phone}
                      onChange={(e) => setPhone(e.target.value)}
                      aria-label="মোবাইল নম্বর"
                    />
                    <span className="bank-withdraw-select-chevron" aria-hidden>
                      ▼
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="row breakpoint no-gutters align-end">
            <div className="col-md-6 col">
              <div className="row no-gutters justify-space-between">
                <div className="col col-10">
                  <label className="input-field-label ma-0 text-capitalize d-block pb-2 bank-withdraw-float-label">
                    উত্তোলনযোগ্য পরিমাণ<span className="red--text ml-1">*</span>
                  </label>
                </div>
                <div className="col col-2 bank-withdraw-help-col">
                  <HelpIcon />
                </div>
                <div className="col col-12">
                  <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined depo-text-field">
                    <div className="v-input__control">
                      <div className="v-input__slot depo-input-slot">
                        <input
                          id="withdraw-amount"
                          autoComplete="off"
                          placeholder="ন্যূনতম ৳ 500 - সর্বোচ্চ ৳ 30,000"
                          type="text"
                          value={amount}
                          onChange={(e) => setAmount(e.target.value)}
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="row px-8 hidden-md-and-up no-gutters align-end">
            <div className="col-md-5 col-lg-4 col">
              <label className="input-field-label ma-0 text-capitalize d-block pb-2">
                মুল্য পরিশোধ পদ্ধতি
                <span className="red--text ml-1">*</span>
              </label>
              <div className="row py-2 no-gutters">
                {METHODS.map((m) => (
                  <div key={`m-${m.id}`} className="col col-auto">
                    <button
                      type="button"
                      onClick={() => setMethod(m.id)}
                      className={`v-btn v-btn--outlined theme--light v-size--default ml-4 pa-2 gateway-button bank-withdraw-gateway${
                        method === m.id ? ' active-gateway-button v-btn--active' : ''
                      }`}
                      style={{ height: '100%', minWidth: 90 }}
                    >
                      <span className="v-btn__content">
                        <div className="row no-gutters bank-withdraw-gateway-inner">
                          <div className="pt-1 pb-0 col">
                            <img src={staticSvg(m.src)} alt="" />
                          </div>
                        </div>
                      </span>
                    </button>
                  </div>
                ))}
              </div>
            </div>
          </div>

          <div className="row px-8 pt-4 hidden-md-and-up no-gutters align-end">
            <div className="col-md-5 col-lg-4 col">
              <label className="input-field-label ma-0 text-capitalize d-block pb-2 sr-only" htmlFor="withdraw-phone-mobile">
                Select your phone
              </label>
              <div className="v-input theme--light v-text-field v-text-field--outlined v-select bank-withdraw-mobile-select-wrap">
                <div className="v-input__control">
                  <div className="v-input__slot depo-input-slot bank-withdraw-select-slot">
                    <input
                      id="withdraw-phone-mobile"
                      className="bank-withdraw-native-select"
                      type="tel"
                      inputMode="numeric"
                      autoComplete="tel"
                      placeholder="মোবাইল নম্বর"
                      value={phone}
                      onChange={(e) => setPhone(e.target.value)}
                      aria-label="মোবাইল নম্বর"
                    />
                    <span className="bank-withdraw-select-chevron" aria-hidden>
                      ▼
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="row breakpoint no-gutters align-end pb-4">
            <div className="col-md-6 col-12">
              <button
                type="submit"
                disabled={submitDisabled}
                aria-busy={busy}
                className="dialog-button theme-button withdraw-width v-btn v-btn--has-bg theme--light v-size--default withdraw-btn-desktop"
              >
                <span className="v-btn__content">উত্তোলন</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  )
}
