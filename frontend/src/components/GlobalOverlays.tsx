import { CurrencyLanguageDialog } from './CurrencyLanguageDialog'

type Props = {
  drawerOpen: boolean
  onCloseDrawer: () => void
  currencyOpen: boolean
  onCloseCurrency: () => void
}

/** `global-overlays.blade.php` — stubs + drawer scrim + currency/language dialog. */
export function GlobalOverlays({ drawerOpen, onCloseDrawer, currencyOpen, onCloseCurrency }: Props) {
  return (
    <>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>
      <div role="dialog" className="v-dialog__container" style={{ position: 'relative' }}></div>
      <div data-v-136dc7e0="" role="dialog" className="v-dialog__container"></div>

      <div id="my_custom_link" className="floating-left">
        <img src="/static/image/icon/icon-live-chat.png" alt="live-chat" />
      </div>
      <CurrencyLanguageDialog open={currencyOpen} onClose={onCloseCurrency} />

      <div
        id="nav-drawer-overlay"
        className="v-overlay theme--dark"
        style={{
          zIndex: 300,
          position: 'fixed',
          inset: 0,
          pointerEvents: drawerOpen ? 'auto' : 'none',
        }}
        onClick={onCloseDrawer}
        onKeyDown={(e) => e.key === 'Escape' && drawerOpen && onCloseDrawer()}
        role="presentation"
        aria-hidden={!drawerOpen}
      >
        <div
          className="v-overlay__scrim"
          style={{
            opacity: drawerOpen ? 0.46 : 0,
            backgroundColor: 'rgb(33, 33, 33)',
            borderColor: 'rgb(33, 33, 33)',
            height: '100%',
            transition: 'opacity 0.2s ease',
          }}
        />
      </div>
    </>
  )
}
