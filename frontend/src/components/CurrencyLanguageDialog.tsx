import { useEffect, useState } from 'react'

type LangBtn = { value: string; text: string; defaultActive?: boolean }

type CurrencyRow = {
  code: string
  flag: string
  label: string
  langs: [LangBtn, LangBtn]
  showDividerAfter?: boolean
}

const CURRENCY_ROWS: CurrencyRow[] = [
  {
    code: 'bdt',
    flag: '/static/image/country/BDT.svg',
    label: '৳ BDT',
    langs: [
      { value: 'bdten', text: 'English' },
      { value: 'bdtbd', text: 'Bengali', defaultActive: true },
    ],
    showDividerAfter: true,
  },
  {
    code: 'inr',
    flag: '/static/image/country/INR.svg',
    label: '₹ INR',
    langs: [
      { value: 'inrenin', text: 'English' },
      { value: 'inrhi', text: 'Hindi' },
    ],
    showDividerAfter: true,
  },
  {
    code: 'npr',
    flag: '/static/image/country/NPR.svg',
    label: 'रु NPR',
    langs: [
      { value: 'nprenne', text: 'English' },
      { value: 'nprne', text: 'Nepalese' },
    ],
    showDividerAfter: true,
  },
  {
    code: 'pkr',
    flag: '/static/image/country/PKR.svg',
    label: '₨ PKR',
    langs: [
      { value: 'pkrenpk', text: 'English' },
      { value: 'pkrur', text: 'Urdu' },
    ],
    showDividerAfter: false,
  },
]

function CurrencyLangRow({ row }: { row: CurrencyRow }) {
  const defaultVal = row.langs.find((l) => l.defaultActive)?.value ?? row.langs[0].value
  const [active, setActive] = useState(defaultVal)

  return (
    <div className="row no-gutters align-center justify-space-between">
      <div className="col col-2">
        <div className="v-avatar language-button" style={{ height: 48, minWidth: 48, width: 48 }}>
          <img src={row.flag} alt="" />
        </div>
      </div>
      <div className="text-center col col-2">
        <label>{row.label}</label>
      </div>
      <div className="col col-8">
        <div className="full-width v-item-group theme--light v-btn-toggle">
          <div className="row no-gutters">
            {row.langs.map((lang) => (
              <div key={lang.value} className="text-right col col-6 px-3">
                <button
                  type="button"
                  value={lang.value}
                  className={`full-width font-weight-bold v-btn v-btn--outlined theme--light v-size--default currency-lang-btn${
                    active === lang.value ? ' v-item--active v-btn--active' : ''
                  }`}
                  onClick={() => setActive(lang.value)}
                >
                  <span className="v-btn__content">{lang.text}</span>
                </button>
              </div>
            ))}
          </div>
        </div>
      </div>
      {row.showDividerAfter ? (
        <div className="my-2 col col-12">
          <hr role="separator" aria-orientation="horizontal" className="language-divider v-divider theme--light" />
        </div>
      ) : (
        <div className="my-2 col col-12"></div>
      )}
    </div>
  )
}

type Props = {
  open: boolean
  onClose: () => void
}

/** `components/currency-language-dialog.blade.php` — z-index from `babu88-shell.css`. */
export function CurrencyLanguageDialog({ open, onClose }: Props) {
  useEffect(() => {
    if (!open) return
    const onKey = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose()
    }
    window.addEventListener('keydown', onKey)
    return () => window.removeEventListener('keydown', onKey)
  }, [open, onClose])

  return (
    <div
      id="currency-language-dialog-root"
      className={`currency-language-dialog-root${open ? ' is-open' : ''}`}
      aria-hidden={!open}
    >
      <div
        className="currency-language-dialog-scrim"
        aria-hidden="true"
        onClick={onClose}
        onKeyDown={(e) => e.key === 'Enter' && onClose()}
        role="presentation"
      />
      <div
        className="currency-language-dialog-sheet"
        role="dialog"
        aria-modal="true"
        aria-labelledby="currency-dialog-title"
        tabIndex={-1}
      >
        <div className="dialog-card v-card v-sheet theme--light">
          <div className="row no-gutters justify-space-between dialog-header pt-5 px-9">
            <div className="col col-11">
              <label id="currency-dialog-title" className="dialog-title pt-3 ma-0 text-capitalize d-block full-width">
                Currency and Language
              </label>
            </div>
            <div className="d-flex align-center justify-center pt-3 col col-1">
              <button
                type="button"
                className="v-icon notranslate v-icon--link mdi mdi-close theme--light dialog-close-icon currency-language-dialog-close"
                aria-label="Close"
                onClick={onClose}
              />
            </div>
          </div>
          <div className="row no-gutters px-9 py-3">
            <div className="col col-12">
              <hr role="separator" aria-orientation="horizontal" className="dialog-divider v-divider theme--light" />
            </div>
          </div>
          <div className="row d-block dialog-row no-gutters pa-6 pt-0">
            <div className="row no-gutters">
              <div className="col col-12 language_panel px-3">
                {CURRENCY_ROWS.map((row) => (
                  <CurrencyLangRow key={row.code} row={row} />
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
