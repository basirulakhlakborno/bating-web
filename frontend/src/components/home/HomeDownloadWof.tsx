/** Download app banners + vertical divider + WoF spin GIF from `bg-filter.blade.php`. */
export function HomeDownloadWof() {
  return (
    <div className="pb-4">
      <div className="row font-weight-bold hidden-md-and-up no-gutters align-end">
        <label>ডাউনলোড করুন</label>
      </div>
      <div className="row mx-0 no-gutters justify-center">
        <div className="pt-2 download-banner col col-12">
          <div className="v-image v-responsive hidden-sm-and-down banner-img theme--light">
            <div className="v-responsive__sizer" style={{ paddingBottom: '37.5%' }}></div>
            <div
              className="v-image__image v-image__image--cover"
              style={{
                backgroundImage:
                  'url("https://babu88.gold/static/image/banner/downloadClient/bdt/bd_bb88_downloadnow_appbanner_desktop.jpg")',
                backgroundPosition: 'center center',
              }}
            ></div>
            <div className="v-responsive__content" style={{ width: 1920 }}></div>
          </div>
          <div className="v-image v-responsive hidden-md-and-up banner-img theme--light">
            <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
            <div className="v-responsive__content"></div>
          </div>
        </div>
      </div>

      <div className="row fill-height hidden-sm-and-down justify-center" style={{ alignItems: 'center', gap: 16 }}>
        <hr role="separator" aria-orientation="vertical" className="v-divider v-divider--vertical theme--light" />
        <div>
          <div className="v-image v-responsive wofClass theme--light" style={{ height: 70, width: 72 }}>
            <div className="v-responsive__sizer" style={{ paddingBottom: '105.521%' }}></div>
            <div
              className="v-image__image v-image__image--cover"
              style={{
                backgroundImage: 'url("https://babu88.gold/static/image/wof/wofSpin.gif")',
                backgroundPosition: 'center center',
              }}
            ></div>
            <div className="v-responsive__content"></div>
          </div>
        </div>
      </div>
    </div>
  )
}
