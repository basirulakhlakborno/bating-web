export function DownloadBar() {
  return (
    <div className="row download-bar no-gutters mobile-only">
      <button type="button" className="v-icon notranslate mr-2 v-icon--link mdi mdi-close theme--light"></button>
      <img
        width={32}
        height={32}
        src="/static/image/layout/download-app.png"
        alt="download"
        className="mr-2"
      />
      <div className="col">
        <label>এখনই আমাদের APP সংস্করণ ডাউনলোড করুন!</label>
      </div>
      <button
        type="button"
        className="download-bar-button subtitle-1 v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default"
      >
        <span className="v-btn__content">ডাউনলোড</span>
      </button>
    </div>
  )
}
