import { Link } from 'react-router-dom'
import { useState, type CSSProperties, type ReactNode } from 'react'
import { homeGameMenuItems } from '../../config/homeGameMenu'
import type { FeaturedGame } from '../../hooks/useSiteLayout'
import { useSiteLayout } from '../../hooks/useSiteLayout'
import { HomeMatchesHighlights } from './HomeMatchesHighlights'
import { HomeReferralPromo } from './HomeReferralPromo'
import { HomeDownloadWof } from './HomeDownloadWof'

function FeaturedGameLink({ game, className, children }: { game: FeaturedGame; className?: string; children: ReactNode }) {
  const href = game.href?.trim() ?? ''
  if (!href) {
    return <div className={className}>{children}</div>
  }
  if (href.startsWith('http://') || href.startsWith('https://')) {
    return (
      <a href={href} target="_blank" rel="noopener noreferrer" className={className ? `${className} text-decoration-none` : 'text-decoration-none'}>
        {children}
      </a>
    )
  }
  return (
    <Link to={href} className={className ? `${className} text-decoration-none` : 'text-decoration-none'}>
      {children}
    </Link>
  )
}

export function HomeBgFilter() {
  const site = useSiteLayout()
  const featuredGames = site?.layoutFeaturedGames ?? []
  const [activeMenu, setActiveMenu] = useState(() => homeGameMenuItems.findIndex((x) => x.defaultSelected))

  const providerLabel = (g: FeaturedGame) =>
    g.provider?.trim() || g.category?.name_en?.trim() || g.category?.name_bn?.trim() || ''

  return (
    <div className="bg_filter">
      <div className="game-menu pb-4">
        <div>
          <div id="game-menu-full" className="row game-menu-wrapper pb-2 hidden-md-and-up game-menu-row no-gutters">
            <div className="d-flex pt-3 col col-12">
              {homeGameMenuItems.map((item, idx) => (
                <div key={item.title} className={idx === 0 ? 'mx-auto pl-3' : 'mx-auto'}>
                  <Link
                    to={item.to}
                    className={`text-decoration-none v-card v-card--link v-sheet theme--light game-menu-button font-weight-bold subtitle-1${
                      idx === activeMenu ? ' selected' : ''
                    }`}
                    onClick={() => setActiveMenu(idx)}
                  >
                    <div
                      className="game-menu-image"
                      style={{ ['--src' as never]: `url('${item.holder}')` } as CSSProperties}
                    >
                      <img src={item.icon} alt="" className="side-menu-icon" />
                    </div>
                    <div className="game-menu-title">{item.title}</div>
                  </Link>
                </div>
              ))}
            </div>
          </div>

          <div className="row mt-0 hidden-md-and-up mobile-provider-card-row left-right-gap">
            <div className="col col-12">
              <div className="row new-gametab-padding ld-gap">
                {featuredGames.map((game) => (
                  <FeaturedGameLink key={game.id} game={game} className="mobile-provider-card-item col gT_homepageHot">
                    <div className="v-image v-responsive banner-img theme--light homepageHot_img">
                      <div className="v-responsive__sizer" style={{ paddingBottom: '100%' }}></div>
                      <div
                        className="v-image__image v-image__image--cover"
                        style={{
                          backgroundImage: game.thumbnail_path ? `url("${game.thumbnail_path}")` : undefined,
                          backgroundColor: game.thumbnail_path ? undefined : 'rgb(42, 42, 42)',
                          backgroundPosition: 'center center',
                        }}
                      ></div>
                      <div className="v-responsive__content">
                        <img src="/static/image/other/hot-icon.png" alt="" className="img-hot-home pos_right_top" />
                      </div>
                    </div>
                  </FeaturedGameLink>
                ))}
              </div>
            </div>
          </div>

          <div className="row mt-0 hidden-sm-and-down mobile-provider-card-row justify-start align-center no-gutters" style={{ gap: '2.2%' }}>
            <div className="title_hotGameDesktop col col-12">{'\u09B9\u09CD\u099F \u0997\u09C7\u09AE\u09B8'}</div>
            <div className="row align-center no-gutters" style={{ width: '100%' }}>
              {featuredGames.map((game) => (
                <FeaturedGameLink key={game.id} game={game} className="desktop-provider-card-item pt-3 col gT_homepageHot">
                  <div className="pa-0 col" style={{ width: '95%' }}>
                    <div className="pa-0 col col-12">
                      <div className="v-image v-responsive game-banner-img theme--light homepageHot_img">
                        <div className="v-responsive__sizer" style={{ paddingBottom: '100%' }}></div>
                        <div
                          className="v-image__image v-image__image--cover"
                          style={{
                            backgroundImage: game.thumbnail_path ? `url("${game.thumbnail_path}")` : undefined,
                            backgroundColor: game.thumbnail_path ? undefined : 'rgb(42, 42, 42)',
                            backgroundPosition: 'center center',
                          }}
                        ></div>
                        <div className="v-responsive__content">
                          <div className="v-overlay play-overlay v-overlay--absolute v-overlay--active theme--dark" style={{ zIndex: 5 }}>
                            <div
                              className="v-overlay__scrim"
                              style={{ opacity: 0, backgroundColor: 'rgb(33, 33, 33)', borderColor: 'rgb(33, 33, 33)' }}
                            ></div>
                            <div className="v-overlay__content">
                              <button type="button" className="playBtn v-btn v-btn--icon v-btn--round theme--dark v-size--default">
                                <span className="v-btn__content">
                                  <div className="v-avatar playBtnIcon" style={{ height: 60, minWidth: 60, width: 60 }}>
                                    <img src="/static/svg/play_btn.svg" alt="" />
                                  </div>
                                </span>
                              </button>
                            </div>
                          </div>
                          <img src="/static/image/other/hot-icon.png" alt="" className="img-hot-home pos_right_top" />
                        </div>
                      </div>
                    </div>
                    <div className="pa-0 col col-12">
                      <span className="hot-game-title">{game.title}</span>
                    </div>
                    <div className="pa-0 col col-12">
                      <span className="rng_providerLabel">{providerLabel(game)}</span>
                    </div>
                  </div>
                </FeaturedGameLink>
              ))}
            </div>
          </div>

          <div className="py-4">
            <div className="row bg-ambas-row pa-2">
              <div
                className="pa-0 bg-ambas col col-12 tabHeight"
                style={{
                  backgroundImage: 'url("https://jiliwin.9terawolf.com/images/babu/banner/ambas/bb88_banner-CS.jpg")',
                }}
              >
                <div className="col-md-7 ambas hidden-sm-and-down col col-12">
                  <div className="v-image v-responsive hidden-md-and-up banner-img theme--light" style={{ height: '100%', width: '100%' }}>
                    <div className="v-image__image v-image__image--preload v-image__image--cover" style={{ backgroundPosition: 'center center' }}></div>
                    <div className="v-responsive__content"></div>
                  </div>
                  <div className="carousel-controls">
                    <button type="button" className="control-dot"></button>
                    <button type="button" className="control-dot active"></button>
                    <button type="button" className="control-dot"></button>
                    <button type="button" className="control-dot"></button>
                  </div>
                </div>
                <div className="align-center col-md-5 d-flex ambas-vid col col-12">
                  <div className="iframe-box">
                    <iframe
                      src="https://www.youtube.com/embed/_kUu6LRg32U?si=wYQVssK_XtrudPqP"
                      width="100%"
                      height="100%"
                      scrolling="no"
                      title="Babu88 video"
                      style={{ border: 'none', overflow: 'hidden', borderRadius: 10, aspectRatio: '16 / 9' }}
                      allowFullScreen
                      allow="clipboard-write; encrypted-media; picture-in-picture; web-share;"
                    />
                  </div>
                </div>
                <div className="d-flex justify-center hidden-md-and-up col col-12">
                  <div className="d-flex justify-center">
                    <button type="button" className="control-dot"></button>
                    <button type="button" className="control-dot active"></button>
                    <button type="button" className="control-dot"></button>
                    <button type="button" className="control-dot"></button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <HomeMatchesHighlights />
          <HomeReferralPromo />
          <HomeDownloadWof />
        </div>
      </div>
    </div>
  )
}
