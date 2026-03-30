import { useState } from 'react'
import {
  homeDesktopBannerSlides,
  homeMarqueeBlocks,
  homeMobileBannerSlides,
} from '../../data/homeBannerMedia'

function MarqueeContent() {
  return (
    <>
      {homeMarqueeBlocks.map((b, i) => (
        <span key={i} className="pr-6 mr-6">
          <label className="d-inline-block home-announcment-content" style={{ color: 'rgb(255, 206, 1)' }}>
            {b.accent}
          </label>
          <label className="d-inline-block home-announcment-content white--text">{b.body}</label>
        </span>
      ))}
    </>
  )
}

export function HomeBanner() {
  const [mob, setMob] = useState(0)
  const [desk, setDesk] = useState(0)
  const mobN = homeMobileBannerSlides.length
  const deskN = homeDesktopBannerSlides.length

  return (
    <div className="home-banner-box banner-content">
      <div className="row hidden-md-and-up no-gutters">
        <div className="col col-12">
          <div
            className="v-window home-banner-carousel-mobile hidden-md-and-up pb-2 banner_border v-item-group theme--dark v-carousel"
            style={{ height: 'auto' }}
          >
            <div className="v-window__container" style={{ height: 'auto' }}>
              {homeMobileBannerSlides.map((url, i) => (
                <div key={url} className="v-window-item" style={{ display: i === mob ? '' : 'none' }}>
                  <div className="v-image v-responsive v-carousel__item theme--light" style={{ height: 'auto' }}>
                    <div className="v-responsive__content">
                      <div className="v-image v-responsive theme--light" style={{ borderRadius: 20 }}>
                        <div className="v-responsive__sizer" style={{ paddingBottom: '44.4444%' }}></div>
                        <div
                          className="v-image__image v-image__image--cover"
                          style={{ backgroundImage: `url("${url}")`, backgroundPosition: 'center center' }}
                        ></div>
                        <div className="v-responsive__content"></div>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
              <div className="v-window__prev">
                <button
                  type="button"
                  className="v-btn v-btn--icon v-btn--round theme--dark v-size--default"
                  aria-label="Previous visual"
                  onClick={() => setMob((m) => (m - 1 + mobN) % mobN)}
                >
                  <span className="v-btn__content">
                    <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-left theme--dark" style={{ fontSize: 36 }}></i>
                  </span>
                </button>
              </div>
              <div className="v-window__next">
                <button
                  type="button"
                  className="v-btn v-btn--icon v-btn--round theme--dark v-size--default"
                  aria-label="Next visual"
                  onClick={() => setMob((m) => (m + 1) % mobN)}
                >
                  <span className="v-btn__content">
                    <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-right theme--dark" style={{ fontSize: 36 }}></i>
                  </span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="banner-height hidden-sm-and-down">
        <div
          className="v-window home-banner-carousel v-item-group theme--dark v-carousel v-carousel--hide-delimiter-background"
          style={{ height: '100%' }}
        >
          <div className="v-window__container" style={{ height: '100%' }}>
            {homeDesktopBannerSlides.map((slide, i) => (
              <div key={slide.src} className="v-window-item" style={{ display: i === desk ? '' : 'none' }}>
                <div className="v-image v-responsive v-carousel__item theme--light" style={{ height: '100%' }}>
                  <div className="v-responsive__content">
                    <img src={slide.src} alt={slide.alt} className="desktop-banner" />
                  </div>
                </div>
              </div>
            ))}
          </div>
          <div className="v-carousel__controls" style={{ left: 'auto', right: 'auto' }}>
            <div className="v-item-group theme--dark">
              {homeDesktopBannerSlides.map((_, i) => (
                <button
                  key={i}
                  type="button"
                  value={i}
                  className={`v-carousel__controls__item v-btn v-btn--icon v-btn--round theme--dark v-size--small${
                    i === desk ? ' v-item--active v-btn--active' : ''
                  }`}
                  aria-label={`Carousel slide ${i + 1} of ${deskN}`}
                  onClick={() => setDesk(i)}
                >
                  <span className="v-btn__content">
                    <i aria-hidden="true" className="v-icon notranslate mdi mdi-minus theme--dark" style={{ fontSize: 18 }}></i>
                  </span>
                </button>
              ))}
            </div>
          </div>
        </div>
        <button
          type="button"
          className="prev-btn v-btn v-btn--icon v-btn--round theme--light v-size--default"
          style={{ color: 'rgb(0, 0, 0)' }}
          aria-label="Previous slide"
          onClick={() => setDesk((d) => (d - 1 + deskN) % deskN)}
        >
          <span className="v-btn__content">
            <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-left theme--light"></i>
          </span>
        </button>
        <button
          type="button"
          className="next-btn v-btn v-btn--icon v-btn--round theme--light v-size--default"
          style={{ color: 'rgb(0, 0, 0)' }}
          aria-label="Next slide"
          onClick={() => setDesk((d) => (d + 1) % deskN)}
        >
          <span className="v-btn__content">
            <i aria-hidden="true" className="v-icon notranslate mdi mdi-chevron-right theme--light"></i>
          </span>
        </button>
      </div>

      <div className="marquee-row hidden-md-and-up">
        <div className="marquee-wrapper">
          <div className="marquee">
            <div className="marquee-content">
              <MarqueeContent />
            </div>
          </div>
        </div>
      </div>

      <div className="row marquee-row hidden-sm-and-down no-gutters" style={{ padding: '1% 12%' }}>
        <div className="marquee-wrapper">
          <div className="marquee">
            <div className="marquee-content">
              <MarqueeContent />
            </div>
          </div>
        </div>
      </div>

      <div className="row home-page-create-account-container no-gutters" style={{ margin: '0px 12%' }}>
        <div className="v-image v-responsive theme--light">
          <div className="v-responsive__sizer" style={{ paddingBottom: '12.5%' }}></div>
          <div
            className="v-image__image v-image__image--cover"
            style={{
              backgroundImage: 'url("https://jiliwin.9terawolf.com/images/babu/banner/register_banner_home_bd.jpg")',
              backgroundPosition: 'center center',
            }}
          ></div>
          <div className="v-responsive__content" style={{ width: 1920 }}></div>
        </div>
      </div>

      <div data-v-06df79c3="" role="dialog" className="v-dialog__container"></div>
    </div>
  )
}
