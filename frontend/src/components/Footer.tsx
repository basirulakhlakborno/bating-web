import { useState } from 'react'
import { useSiteLayout } from '../hooks/useSiteLayout'

export function Footer() {
  const [seoOpen, setSeoOpen] = useState(false)
  const layout = useSiteLayout()

  const sections = layout?.layoutFooterSections ?? []
  const payments = layout?.layoutPaymentMethods ?? []
  const socials = layout?.layoutSocialLinks ?? []
  const brandUrl = layout?.layoutSiteBrandOfficialUrl ?? ''
  const brandLogo = layout?.layoutSiteBrandLogoPath ?? ''
  const tagline = layout?.layoutSiteBrandTagline ?? ''
  const copyright = layout?.layoutSiteCopyright ?? ''
  const seoMain = layout?.layoutFooterSeoMain ?? { heading: '', intro: '' }
  const seoExpandable = layout?.layoutFooterSeoExpandable ?? {
    section_heading: '',
    columns: [],
  }

  return (
    <footer className="v-footer footer-color v-sheet theme--light" data-booted="true">
      <div className="row no-gutters align-center justify-center">
        {sections.map((section) => (
          <div key={section.id}>
            <div className="col col-12 paddingLR py-1">
              <div className="dotted-line py-3"></div>
            </div>
            <div className="col col-12 paddingLR py-0">
              <div className="row no-gutters">
                <p className="main_title">{section.title_bn}</p>
              </div>
              <div className="row no-gutters">
                {section.items.map((item) => (
                  <div
                    key={item.id}
                    className="d-flex py-1 sponsor-cursor col-md-4 col-lg-3 col-6"
                    style={{ overflow: 'hidden' }}
                  >
                    {item.image_path && (
                      <img
                        width={40}
                        height={40}
                        src={item.image_path}
                        alt={item.title}
                        style={{ flexShrink: 0 }}
                      />
                    )}
                    <div className="sponsor-border" style={{ minWidth: 0 }}>
                      <p className="sponsorship-text" style={{ whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>
                        {item.link_url ? (
                          <a
                            href={item.link_url}
                            target="_blank"
                            rel="noreferrer"
                            style={{ color: 'inherit', textDecoration: 'none' }}
                          >
                            {item.title}
                          </a>
                        ) : (
                          item.title
                        )}
                      </p>
                      {item.subtitle && (
                        <p className="year-text">{item.subtitle}</p>
                      )}
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        ))}

        <div className="col col-12 paddingLR py-1">
          <div className="dotted-line py-3"></div>
        </div>

        {/* Payment methods + Responsible gaming */}
        <div className="row no-gutters justify-space-between paddingLR py-0">
          <div className="py-1 col col-6">
            <div className="row no-gutters">
              <label className="subtitle-1 footer-link-label">
                <p className="main_title">মূল্যপরিশোধ পদ্ধতি</p>
              </label>
            </div>
            <div className="row d-flex align-center no-gutters">
              <div className="row d-flex align-center no-gutters">
                {payments.map((pm) => (
                  <a
                    key={pm.id}
                    href={pm.link_url || '#'}
                    onClick={pm.link_url ? undefined : (e) => e.preventDefault()}
                    aria-label={pm.name}
                  >
                    {pm.image_path && (
                      <img
                        width="60px"
                        src={pm.image_path}
                        alt={pm.alt || pm.name}
                        className="mr-4 mt-2 grayscale-on-hover"
                      />
                    )}
                  </a>
                ))}
              </div>
            </div>
          </div>
          <div className="py-1 col col-6">
            <div className="row no-gutters">
              <p className="main_title">দায়িত্বশীল গেমিং</p>
            </div>
            <div className="row no-gutters">
              <img
                src="/static/svg/btm-18+.svg"
                alt=""
                className="footer-icon"
              />
              <img
                src="/static/svg/btm-gamcare.svg"
                alt=""
                className="footer-icon"
              />
            </div>
          </div>
        </div>

        {/* Brand + Social links */}
        <div className="paddingLR py-5 col col-12">
          <div className="dotted-line py-4"></div>
          <div className="row no-gutters justify-space-between">
            <div className="py-0 col col-6">
              {(brandUrl || brandLogo) && (
                <div className="row no-gutters">
                  <a href={brandUrl || '#'} target="_blank" rel="noreferrer" onClick={brandUrl ? undefined : (e) => e.preventDefault()}>
                    {brandLogo ? (
                      <img src={brandLogo} alt="" className="footer-brand-logo mr-3 mt-0" decoding="async" />
                    ) : null}
                  </a>
                </div>
              )}
              {tagline ? <div className="row align main_title no-gutters">{tagline}</div> : null}
              {copyright ? <div className="row align white--text no-gutters">{copyright}</div> : null}
            </div>
            <div className="py-0 col col-6">
              <div className="row no-gutters">
                <label className="subtitle-1 footer-link-label">
                  <p className="main_title">আমাদের অনুসরণ করো</p>
                </label>
              </div>
              <div className="row no-gutters">
                {socials.map((s) => (
                  <a
                    key={s.id}
                    href={s.url}
                    target="_blank"
                    rel="noreferrer"
                  >
                    {s.icon_path && (
                      <img
                        src={s.icon_path}
                        alt={s.label}
                        className="footer-icon grayscale-on-hover"
                      />
                    )}
                  </a>
                ))}
              </div>
            </div>
          </div>
          <div className="row no-gutters" style={{ display: 'none' }}>
            <div className="col-lg-4 col-12"></div>
          </div>
        </div>

        {/* SEO text */}
        {(seoMain.heading || seoMain.intro) && (
          <>
            <div className="col col-12 paddingLR py-1">
              <div className="dotted-line py-3"></div>
            </div>

            <div
              className="row py-6 paddingLR second_footer no-gutters"
              data-footer-seo=""
            >
              <div className="col col-12">
                {seoMain.heading && (
                  <h3 className="main_title pb-2">{seoMain.heading}</h3>
                )}
                {seoMain.intro && (
                  <p className="seo_text">{seoMain.intro}</p>
                )}
              </div>

              {seoExpandable.columns.length > 0 && (
                <div
                  className="col col-12 px-0 footer-seo-extra"
                  id="footer-seo-extra"
                  hidden={!seoOpen}
                >
                  <div className="row no-gutters">
                    {seoExpandable.section_heading && (
                      <div className="col-lg-12 col-12">
                        <div className="row mt-2 no-gutters">
                          <div className="col col-10 py-2">
                            <h3 className="main_title pb-2">
                              {seoExpandable.section_heading}
                            </h3>
                          </div>
                        </div>
                      </div>
                    )}
                    {seoExpandable.columns.map((col, colIdx) => (
                      <div key={colIdx} className="col-lg-4 col-12">
                        <div className="row mt-2 no-gutters">
                          {col.map((block, blockIdx) => (
                            <div key={blockIdx} className="col col-10 py-2">
                              {block.heading && (
                                <h3 className="main_title pb-2">
                                  {block.heading}
                                </h3>
                              )}
                              {block.body && (
                                <p className="seo_text">{block.body}</p>
                              )}
                            </div>
                          ))}
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {seoExpandable.columns.length > 0 && (
                <div className="col col-12 text-center pt-3 pb-1">
                  <button
                    type="button"
                    className="readMore footer-read-more-btn text-decoration-underline"
                    id="footer-read-more-btn"
                    aria-expanded={seoOpen}
                    aria-controls="footer-seo-extra"
                    onClick={() => setSeoOpen((o) => !o)}
                  >
                    {seoOpen ? 'কম পড়া' : 'আরও পড়ুন'}
                  </button>
                </div>
              )}
            </div>
          </>
        )}
      </div>
    </footer>
  )
}
