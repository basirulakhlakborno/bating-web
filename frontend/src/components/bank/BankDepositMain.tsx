import { useState } from 'react'

const staticSvg = (name: string) => `https://babu88.gold/static/svg/${name}`

const EWALLETS = [
  { id: 'NAGAD', src: 'deposit-ewallet-nagad.svg' },
  { id: 'BKASH', src: 'deposit-ewallet-bkash.svg' },
  { id: 'ROCKET', src: 'deposit-ewallet-rocket.svg' },
  { id: 'UPAY', src: 'deposit-ewallet-upay.svg' },
  { id: 'NAGADM', src: 'deposit-ewallet-nagadm.svg' },
  { id: 'BKASHM', src: 'deposit-ewallet-bkashm.svg' },
] as const

const CHANNELS = [
  { id: 'ZAPPAY', label: 'Zappay' },
  { id: 'PAYTAKA', label: 'Paytaka' },
  { id: 'DP', label: 'DPay' },
  { id: 'PAYTAKAV3', label: 'SEND MONEY' },
] as const

const AMOUNTS = [200, 1000, 5000, 10000, 20000, 30000] as const

function ChipMobile() {
  return (
    <span
      className="percent-label-2 ma-0 pa-1 v-chip v-chip--label theme--light v-size--x-small depo-chip depo-chip--yellow"
    >
      <span className="v-chip__content">+3%</span>
    </span>
  )
}

function ChipDesktop() {
  return (
    <span className="percent-label-2 ma-0 v-chip v-chip--label theme--light v-size--x-small mobile-depo-percent desktop-percent-label-position depo-chip depo-chip--blue">
      <span className="v-chip__content">+3%</span>
    </span>
  )
}

function ChannelChip() {
  return (
    <span className="percent-label-2 ma-0 v-chip v-chip--label theme--light v-size--x-small mobile-depo-percent desktop-percent-size depo-chip depo-chip--yellow">
      <span className="v-chip__content">+3%</span>
    </span>
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

export function BankDepositMain() {
  const [ewallet, setEwallet] = useState<(typeof EWALLETS)[number]['id']>('NAGAD')
  const [channel, setChannel] = useState<(typeof CHANNELS)[number]['id']>('ZAPPAY')
  const [amount, setAmount] = useState('')
  const [preset, setPreset] = useState<number>(200)

  const setAmountFromPreset = (n: number) => {
    setPreset(n)
    setAmount(String(n))
  }

  return (
    <div className="desktop_depo_card v-card v-sheet theme--light">
      <div className="v-card__title hidden-sm-and-down pl-3 ml-7 depo-card-desktop-title">
        <label className="--v-primary-base depo-desktop-txt text-left text-capitalize">আমানত</label>
      </div>
      <div className="bank-detail-card deposit-card v-card v-sheet theme--light elevation-0">
        <div>
          <div className="row breakpoint no-gutters align-end">
            <div className="col col-auto">
              <div className="hidden-md-and-up">
                <label className="input-field-label ma-0 text-capitalize d-block pb-1">
                  মুল্য পরিশোধ পদ্ধতি
                  <span className="red--text ml-1">*</span>
                </label>
              </div>
              <div className="hidden-sm-and-down">
                <label className="input-field-label ma-0 text-capitalize d-block pb-1">
                  আমানত বিকল্প
                  <span className="red--text ml-1">*</span>
                </label>
              </div>
              <div className="row py-2 mb-3 no-gutters depo-ewallet-row">
                {EWALLETS.map((w) => (
                  <div key={w.id} className="col col-auto">
                    <button
                      type="button"
                      value={w.id}
                      onClick={() => setEwallet(w.id)}
                      className={`v-btn v-btn--outlined theme--light v-size--default pa-2 mobile-paymentMethod gateway-button${ewallet === w.id ? ' active-gateway-button v-btn--active' : ''}`}
                      style={{ height: '100%', width: 100 }}
                    >
                      <span className="v-btn__content">
                        <img src={staticSvg(w.src)} alt="" className="depo-gateway-img" />
                      </span>
                    </button>
                  </div>
                ))}
              </div>
            </div>
          </div>

          <form
            className="v-form depo-main-form"
            noValidate
            onSubmit={(e) => {
              e.preventDefault()
            }}
          >
            <div className="row pb-2 breakpoint no-gutters align-end">
              <div className="col-md-12 col">
                <label className="input-field-label ma-0 text-capitalize d-block">
                  আমানত চ্যানেল
                  <span className="red--text ml-1">*</span>
                </label>
                <div className="row py-2 pb-2 no-gutters depo-channel-row">
                  {CHANNELS.map((c) => (
                    <div key={c.id} className="mr-2 col col-auto">
                      <button
                        type="button"
                        value={c.id}
                        onClick={() => setChannel(c.id)}
                        className={`pa-2 theme-button font-weight-bold v-btn v-btn--outlined theme--light v-size--default depo-channel-btn${
                          channel === c.id ? ' active-gateway-button v-btn--active' : ''
                        }`}
                        style={{ height: 'auto' }}
                      >
                        <span className="v-btn__content">
                          <span className="gateway_name">{c.label}</span>
                          <ChannelChip />
                        </span>
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            <div className="row breakpoint no-gutters align-end">
              <div className="col-md-6 col">
                <div className="depo-box">
                  <div className="row no-gutters justify-space-between">
                    <div className="col col-10">
                      <label className="input-field-label ma-0 text-capitalize d-block pb-2 depo-amount-label">
                        আমানত পরিমাণ<span className="red--text ml-1">*</span>
                      </label>
                    </div>
                    <div className="col col-2 depo-help-wrap">
                      <HelpIcon />
                    </div>
                    <div className="col col-12">
                      <div className="v-input input-field elevation-0 hide-details theme--light v-text-field v-text-field--enclosed v-text-field--outlined depo-text-field">
                        <div className="v-input__control">
                          <div className="v-input__slot depo-input-slot">
                            <input
                              id="depo-amount-input"
                              autoComplete="off"
                              placeholder="ন্যূনতম ৳ 200.00 - সর্বোচ্চ ৳ 30,000.00"
                              type="text"
                              value={amount}
                              onChange={(e) => {
                                setAmount(e.target.value)
                                setPreset(0)
                              }}
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <p className="depo-bonus-hint">৳ 400.00 এর নিচে ডিপজিটে কোন বোনাস পাবেন না</p>
              </div>
            </div>

            <div className="row pb-2 breakpoint no-gutters align-end">
              <div className="col">
                <div className="row no-gutters">
                  {AMOUNTS.map((n, i) => (
                    <div key={`m-${n}`} className="pr-2 pb-2 hidden-md-and-up col col-4">
                      <button
                        type="button"
                        onClick={() => setAmountFromPreset(n)}
                        className={`pa-2 full-width theme-button font-weight-bold yellow--text hidden-md-and-up v-btn v-btn--has-bg theme--light v-size--default black depo-amt-mobile${
                          preset === n ? ' active-amount-button v-btn--active' : ''
                        }`}
                        style={{ height: 'auto' }}
                      >
                        <span className="v-btn__content depo-amt-mobile-inner">
                          {i > 0 ? <ChipMobile /> : null}
                          {n}
                        </span>
                      </button>
                    </div>
                  ))}
                  {AMOUNTS.map((n, i) => (
                    <div key={`d-${n}`} className="pr-4 pb-2 hidden-sm-and-down col col-4">
                      <button
                        type="button"
                        onClick={() => setAmountFromPreset(n)}
                        className={`pa-2 full-width theme-button font-weight-bold amt-btn hidden-sm-and-down v-btn v-btn--has-bg theme--light v-size--default depo-amt-desktop${
                          preset === n ? ' active-amount-button-desktop v-btn--active' : ''
                        }`}
                        style={{ height: 'auto' }}
                      >
                        <span className="v-btn__content depo-amt-desktop-inner">
                          {i > 0 ? <ChipDesktop /> : null}
                          {n}
                        </span>
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            <div className="row pb-5 breakpoint no-gutters align-end">
              <div className="col-md-6 col">
                <button
                  type="submit"
                  className="dialog-button theme-button depo-width v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default deposit-btn-desktop"
                >
                  <span className="v-btn__content">আমানত</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  )
}
