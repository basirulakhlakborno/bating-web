import { useState } from 'react'
import {
  homeDesktopBannerSlides,
  homeMarqueeBlocks,
  homeMobileBannerSlides,
} from '../../data/homeBannerMedia'

function BannerChevron({ direction, size }: { direction: 'left' | 'right'; size: number }) {
  const d = direction === 'left' ? 'M15 6 9 12l6 6' : 'M9 6l6 6-6 6'
  return (
    <svg
      className="home-banner-chevron"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      width={size}
      height={size}
      fill="none"
      stroke="currentColor"
      strokeWidth="2.5"
      strokeLinecap="round"
      strokeLinejoin="round"
      aria-hidden
    >
      <path d={d} />
    </svg>
  )
}

function BannerCarouselDash({ size }: { size: number }) {
  return (
    <svg
      className="home-banner-carousel-dash"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      width={size}
      height={size}
      aria-hidden
    >
      <rect x="5" y="11" width="14" height="2" rx="1" fill="currentColor" />
    </svg>
  )
}

function MarqueeSegment({ idPrefix }: { idPrefix: 'a' | 'b' }) {
  return (
    <>
      {homeMarqueeBlocks.map((b, i) => (
        <span key={`${idPrefix}-${i}`} className="marquee-block-item">
          <label className="d-inline-block home-announcment-content" style={{ color: 'rgb(255, 206, 1)' }}>
            {b.accent}
          </label>
          <label className="d-inline-block home-announcment-content white--text">{b.body}</label>
        </span>
      ))}
    </>
  )
}

function MarqueeLoop() {
  return (
    <div className="marquee">
      <div className="marquee-track">
        <div className="marquee-segment">
          <MarqueeSegment idPrefix="a" />
        </div>
        <div className="marquee-segment" aria-hidden="true">
          <MarqueeSegment idPrefix="b" />
        </div>
      </div>
    </div>
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
                    <BannerChevron direction="left" size={36} />
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
                    <BannerChevron direction="right" size={36} />
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
                    <BannerCarouselDash size={18} />
                  </span>
                </button>
              ))}
            </div>
          </div>
        </div>
        <button
          type="button"
          className="prev-btn v-btn v-btn--icon v-btn--round theme--light v-size--default"
          aria-label="Previous slide"
          onClick={() => setDesk((d) => (d - 1 + deskN) % deskN)}
        >
          <span className="v-btn__content">
            <BannerChevron direction="left" size={28} />
          </span>
        </button>
        <button
          type="button"
          className="next-btn v-btn v-btn--icon v-btn--round theme--light v-size--default"
          aria-label="Next slide"
          onClick={() => setDesk((d) => (d + 1) % deskN)}
        >
          <span className="v-btn__content">
            <BannerChevron direction="right" size={28} />
          </span>
        </button>
      </div>

      <div className="marquee-row hidden-md-and-up">
        <div className="marquee-wrapper">
          <MarqueeLoop />
        </div>
      </div>

      <div className="row marquee-row hidden-sm-and-down no-gutters" style={{ padding: '1% 12%' }}>
        <div className="marquee-wrapper">
          <MarqueeLoop />
        </div>
      </div>

      <div className="row home-page-create-account-container home-register-banner no-gutters">
        <div className="v-image v-responsive theme--light">
          <div
            className="v-responsive__sizer home-register-banner__sizer"
            style={{ paddingBottom: '12.5%' }}
          ></div>
          <div
            className="v-image__image v-image__image--cover"
            style={{
              backgroundImage: 'url("https://jiliwin.9terawolf.com/images/babu/banner/register_banner_home_bd.jpg")',
              backgroundPosition: 'center center',
            }}
          ></div>
          <div className="v-responsive__content home-register-banner__content" />
        </div>
      </div>

      <div data-v-06df79c3="" role="dialog" className="v-dialog__container"></div>
    </div>
  )
}
