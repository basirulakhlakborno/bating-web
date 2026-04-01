import { useCallback, useEffect, useMemo, useState } from 'react'
import { playerJson } from '../../lib/playerApi'

const HISTORY_TABS = [
  { id: 'deposit', label: 'জমার ইতিহাস' },
  { id: 'withdrawal', label: 'প্রত্যাহারের ইতিহাস' },
  { id: 'transfer', label: 'স্থানান্তর ইতিহাস' },
  { id: 'bonus', label: 'বোনাস ইতিহাস' },
  { id: 'turnover', label: 'টার্নওভার ইতিহাস' },
  { id: 'bet', label: 'বেট হিস্টোরি' },
  { id: 'reward', label: 'পুরস্কারের ইতিহাস' },
  { id: 'freespin', label: 'ফ্রিস্পিন হিস্টোরি' },
] as const

type HistoryTabId = (typeof HISTORY_TABS)[number]['id']

const DEPOSIT_COLUMNS = [
  { key: 'date', label: 'তারিখ', sortable: true },
  { key: 'method', label: 'Deposit Method' },
  { key: 'channel', label: 'Payment Channel' },
  { key: 'id', label: 'Deposit ID' },
  { key: 'amount', label: 'Deposit Amount' },
  { key: 'bonus', label: 'বোনাস' },
  { key: 'status', label: 'স্ট্যাটাস' },
  { key: 'remark', label: 'মন্তব্য' },
]

const WITHDRAWAL_COLUMNS = [
  { key: 'date', label: 'তারিখ', sortable: true },
  { key: 'method', label: 'পদ্ধতি' },
  { key: 'amount', label: 'পরিমাণ' },
  { key: 'reference', label: 'রেফারেন্স' },
  { key: 'phone', label: 'ফোন' },
  { key: 'status', label: 'স্ট্যাটাস' },
]

type DepositApiRow = {
  id: number
  kind?: string
  created_at?: string
  amount?: string
  currency_code?: string
  method?: string
  channel?: string
  reference?: string | null
  status?: string
  bonus?: string
  remark?: string
}

type WithdrawalApiRow = {
  id: number
  kind?: string
  created_at?: string
  amount?: string
  currency_code?: string
  method?: string
  account_phone?: string | null
  reference?: string | null
  status?: string
}

function formatWhen(iso?: string) {
  if (!iso) return '—'
  try {
    return new Date(iso).toLocaleString()
  } catch {
    return iso
  }
}

function ChevronDown({ large }: { large?: boolean }) {
  return (
    <svg
      className={large ? 'history-chevron-lg' : undefined}
      width={large ? 36 : 24}
      height={large ? 36 : 24}
      viewBox="0 0 24 24"
      aria-hidden
    >
      <path fill="currentColor" d="M7 10l5 5 5-5H7z" />
    </svg>
  )
}

function SearchIcon() {
  return (
    <span className="history-search-icon" aria-hidden>
      <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
      </svg>
    </span>
  )
}

export function BankHistoryMain() {
  const [activeTab, setActiveTab] = useState<HistoryTabId>('deposit')
  const [dateFrom, setDateFrom] = useState('')
  const [dateTo, setDateTo] = useState('')
  const [loading, setLoading] = useState(false)
  const [deposits, setDeposits] = useState<DepositApiRow[]>([])
  const [withdrawals, setWithdrawals] = useState<WithdrawalApiRow[]>([])

  const fetchHistory = useCallback(async () => {
    setLoading(true)
    try {
      const q = new URLSearchParams()
      if (dateFrom.trim()) q.set('from', dateFrom.trim())
      if (dateTo.trim()) q.set('to', dateTo.trim())
      const path = `/api/bank/history${q.toString() ? `?${q.toString()}` : ''}`
      const { ok, data } = await playerJson<{ deposits?: DepositApiRow[]; withdrawals?: WithdrawalApiRow[] }>(path, {
        method: 'GET',
      })
      if (ok) {
        setDeposits(data.deposits ?? [])
        setWithdrawals(data.withdrawals ?? [])
      } else {
        window.showToast?.('ইতিহাস লোড করা যায়নি।', { type: 'error' })
      }
    } finally {
      setLoading(false)
    }
  }, [dateFrom, dateTo])

  useEffect(() => {
    void fetchHistory()
    // Intentionally once on mount; search button uses latest fetchHistory with current dates.
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [])

  const columns = useMemo(() => {
    if (activeTab === 'withdrawal') return WITHDRAWAL_COLUMNS
    if (activeTab === 'deposit') return DEPOSIT_COLUMNS
    return [{ key: 'placeholder', label: 'বিবরণ', sortable: false }]
  }, [activeTab])

  const rowsForTab = useMemo(() => {
    if (activeTab === 'deposit') return deposits
    if (activeTab === 'withdrawal') return withdrawals
    return []
  }, [activeTab, deposits, withdrawals])

  const showEmpty =
    (activeTab === 'deposit' || activeTab === 'withdrawal') && !loading && rowsForTab.length === 0

  const showPlaceholderTab = activeTab !== 'deposit' && activeTab !== 'withdrawal'

  return (
    <div className="desktop-flex-column bank-history-root">
      <div className="pb-3 histories-type v-card v-sheet theme--light bank-history-type-card">
        <div className="v-card__title bank-history-page-title">ইতিহাস</div>
        <div className="v-card__subtitle ht-subtitle">History Type</div>
        <div className="row px-10 pb-3 hidden-sm-and-down no-gutters justify-end bank-history-tab-row">
          <div className="col col-12">
            <div className="hl-type-header" role="tablist" aria-label="ইতিহাসের ধরন">
              {HISTORY_TABS.map((t) => (
                <button
                  key={t.id}
                  type="button"
                  role="tab"
                  aria-selected={activeTab === t.id}
                  onClick={() => setActiveTab(t.id)}
                  className={`player-history-tab v-btn v-btn--has-bg theme--light v-size--default${
                    activeTab === t.id ? ' buttonPrimary no-opacity history-tab--active' : ''
                  }`}
                >
                  <span className="v-btn__content">{t.label}</span>
                </button>
              ))}
            </div>
          </div>
        </div>
      </div>

      <div className="bank-history-body-spacer" style={{ paddingTop: 12 }}>
        <div className="row hidden-md-and-up no-gutters bank-history-mobile-filters">
          <div className="mobile-filter-col col col-5">
            <div className="mobile-menu-card-wrapper-promotion v-card v-sheet theme--light">
              <button
                type="button"
                className="mobile-category-menuBtn-promotion v-btn v-btn--block v-btn--is-elevated v-btn--has-bg theme--light v-size--default"
                aria-label="ফিল্টার"
              >
                <span className="v-btn__content bank-history-mobile-btn-inner">
                  <span className="bank-history-mobile-placeholder" />
                  <ChevronDown large />
                </span>
              </button>
            </div>
          </div>
          <div className="mobile-filter-col col col-4">
            <div className="mobile-menu-card-wrapper-promotion v-card v-sheet theme--light">
              <button
                type="button"
                className="mobile-category-menuBtn-promotion v-btn v-btn--block v-btn--is-elevated v-btn--has-bg theme--light v-size--default"
                aria-label="ধরন"
              >
                <span className="v-btn__content bank-history-mobile-btn-inner">
                  <span className="bank-history-mobile-deposit-label">DEPOSIT</span>
                  <ChevronDown large />
                </span>
              </button>
            </div>
          </div>
        </div>

        <div className="desktop_card_history pt-3 v-card v-sheet theme--light elevation-0">
          <p className="px-10 ml-3 hidden-sm-and-down bank-history-date-label">অনুসন্ধানের তারিখ</p>
          <div className="bank-detail-card history-card v-card v-sheet theme--light elevation-0">
            <div className="row no-gutters">
              <div className="col col-12">
                <div className="bank-history-date-search-row">
                  <div className="v-input date-search elevation-0 v-input--hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined">
                    <div className="v-input__control">
                      <div className="v-input__slot depo-input-slot history-date-slot">
                        <input
                          id="history-date-from"
                          placeholder="YYYY-MM-DD"
                          type="text"
                          value={dateFrom}
                          onChange={(e) => setDateFrom(e.target.value)}
                          aria-label="শুরুর তারিখ"
                        />
                        <span className="history-input-append">
                          <SearchIcon />
                        </span>
                      </div>
                    </div>
                  </div>
                  <div className="v-input date-search ml-3 elevation-0 v-input--hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined">
                    <div className="v-input__control">
                      <div className="v-input__slot depo-input-slot history-date-slot">
                        <input
                          id="history-date-to"
                          placeholder="YYYY-MM-DD"
                          type="text"
                          value={dateTo}
                          onChange={(e) => setDateTo(e.target.value)}
                          aria-label="শেষ তারিখ"
                        />
                        <span className="history-input-append">
                          <SearchIcon />
                        </span>
                      </div>
                    </div>
                  </div>
                  <button
                    type="button"
                    disabled={loading}
                    onClick={() => void fetchHistory()}
                    className="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default subtitle-1 embedded-register-button mx-3 bank-history-search-btn"
                  >
                    <span className="v-btn__content">{loading ? '…' : 'অনুসন্ধান'}</span>
                  </button>
                </div>
              </div>
            </div>

            <div className="fullHeight mt-6 col col-12 bank-history-table-wrap">
              <div className="v-data-table elevation-0 fullHeight theme--light">
                <div className="v-data-table__wrapper">
                  <table className="bank-history-table">
                    <thead>
                      <tr>
                        {columns.map((col) => (
                          <th key={col.key} className="referral-table-header text-start">
                            <span>
                              {col.label}
                              {col.sortable ? (
                                <span className="bank-history-sort-wrap">
                                  <button type="button" className="bank-history-sort-btn" aria-label="Sort">
                                    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden>
                                      <path fill="currentColor" d="M7 14l5-5 5 5H7z" />
                                    </svg>
                                  </button>
                                </span>
                              ) : null}
                            </span>
                          </th>
                        ))}
                      </tr>
                    </thead>
                    <tbody>
                      {showPlaceholderTab ? (
                        <tr>
                          <td colSpan={columns.length} className="text-center py-6">
                            এই ধরনের ইতিহাস এখনও সার্ভার থেকে পাওয়া যায়নি।
                          </td>
                        </tr>
                      ) : activeTab === 'deposit' ? (
                        deposits.map((row) => (
                          <tr key={`d-${row.id}`}>
                            <td>{formatWhen(row.created_at)}</td>
                            <td>{row.method ?? '—'}</td>
                            <td>{row.channel ?? '—'}</td>
                            <td>{row.id}</td>
                            <td>
                              {row.amount ?? '—'} {row.currency_code ?? ''}
                            </td>
                            <td>{row.bonus ?? '—'}</td>
                            <td>{row.status ?? '—'}</td>
                            <td>{row.remark ?? ''}</td>
                          </tr>
                        ))
                      ) : (
                        withdrawals.map((row) => (
                          <tr key={`w-${row.id}`}>
                            <td>{formatWhen(row.created_at)}</td>
                            <td>{row.method ?? '—'}</td>
                            <td>
                              {row.amount ?? '—'} {row.currency_code ?? ''}
                            </td>
                            <td>{row.reference ?? '—'}</td>
                            <td>{row.account_phone ?? '—'}</td>
                            <td>{row.status ?? '—'}</td>
                          </tr>
                        ))
                      )}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div className="row bank-history-empty-footer">
              <div className="text-center pt-0 pb-8 col col-12">
                <span className="referral-table-header subtitle-2">
                  {loading ? 'লোড হচ্ছে…' : showEmpty ? 'কোন তথ্য নেই' : ''}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
