import { useState } from 'react'

/**
 * Port of `resources/views/components/footer.blade.php` — same markup/classes, no Laravel.
 */
export function Footer() {
  const [seoOpen, setSeoOpen] = useState(false)

  return (
    <footer className="v-footer footer-color v-sheet theme--light" data-booted="true">
      <div className="row no-gutters align-center justify-center">
        <div className="col col-12 paddingLR py-1">
          <div className="dotted-line py-3"></div>
        </div>

        <div className="col col-12 paddingLR py-0">
          <div className="row no-gutters">
            <p className="main_title">ব্র্যান্ড অ্যাম্বাসেডর</p>
          </div>
          <div className="row no-gutters">
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/samira_mahi_khan.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Samira Mahi Khan</p>
                <p className="year-text">2024/2025</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/apu_biswas.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Apu Biswas</p>
                <p className="year-text">2023/2024</p>
              </div>
            </div>
          </div>
        </div>

        <div className="col col-12 paddingLR py-1">
          <div className="dotted-line py-3"></div>
        </div>

        <div className="col col-12 paddingLR py-0">
          <div className="row no-gutters">
            <p className="main_title">স্পনসরশিপ</p>
          </div>
          <div className="row no-gutters">
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/vegas_vikings.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Vegas Vikings</p>
                <p className="year-text">2025/2026</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/sudurpaschim_royals.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Sudurpaschim Royals</p>
                <p className="year-text">2024/2025</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/telugu_warriors.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Telugu Warriors</p>
                <p className="year-text">2024/2025</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/colombo_strikers.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Colombo Strikers</p>
                <p className="year-text">2024/2025</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/grand_cayman_jaguars.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Grand Cayman Jaguars</p>
                <p className="year-text">2024/2025</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/montreal_tigers.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Montreal Tigers</p>
                <p className="year-text">2023/2024</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/dambulla_aurea.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Dambulla Aura</p>
                <p className="year-text">2023/2024</p>
              </div>
            </div>
            <div className="d-flex py-1 sponsor-cursor col-md-4 col-lg-2 col-6">
              <img width={40} height={40} src="/static/image/footer/northern_warriors.png" alt="" />
              <div className="sponsor-border">
                <p className="sponsorship-text">Northern Warriors</p>
                <p className="year-text">2023/2024</p>
              </div>
            </div>
          </div>
        </div>

        <div className="col col-12 paddingLR py-1">
          <div className="dotted-line py-3"></div>
        </div>

        <div className="row no-gutters justify-space-between paddingLR py-0">
          <div className="py-1 col col-6">
            <div className="row no-gutters">
              <label className="subtitle-1 footer-link-label">
                <p className="main_title">মূল্যপরিশোধ পদ্ধতি</p>
              </label>
            </div>
            <div className="row d-flex align-center no-gutters">
              <div className="row d-flex align-center no-gutters">
                <a href="#" onClick={(e) => e.preventDefault()} aria-label="bKash">
                  <img
                    width="60px"
                    src="/static/image/footer/icon_footer_bkash_colour.svg"
                    alt="bkash9"
                    className="mr-4 mt-2 grayscale-on-hover"
                  />
                </a>
                <a href="#" onClick={(e) => e.preventDefault()} aria-label="Nagad">
                  <img
                    width="60px"
                    src="/static/image/footer/icon_footer_nagad_colour.svg"
                    alt="nagad"
                    className="mr-4 mt-2 grayscale-on-hover"
                  />
                </a>
                <a href="#" onClick={(e) => e.preventDefault()} aria-label="Rocket">
                  <img
                    width="60px"
                    src="/static/image/footer/icon_footer_rocket_colour.svg"
                    alt="rocket"
                    className="mr-4 mt-1 grayscale-on-hover"
                  />
                </a>
                <a href="#" onClick={(e) => e.preventDefault()} aria-label="Upay">
                  <img
                    width="60px"
                    src="/static/image/footer/icon_footer_upay_colour.svg"
                    alt="upay"
                    className="mr-4 mt-2 grayscale-on-hover"
                  />
                </a>
              </div>
            </div>
          </div>
          <div className="py-1 col col-6">
            <div className="row no-gutters">
              <p className="main_title">দায়িত্বশীল গেমিং</p>
            </div>
            <div className="row no-gutters">
              <img src="/static/svg/btm-18+.svg" alt="" className="footer-icon" />
              <img src="/static/svg/btm-gamcare.svg" alt="" className="footer-icon" />
            </div>
          </div>
        </div>

        <div className="paddingLR py-5 col col-12">
          <div className="dotted-line py-4"></div>
          <div className="row no-gutters justify-space-between">
            <div className="py-0 col col-6">
              <div className="row no-gutters">
                <a href="https://babu88official.com" target="_blank" rel="noreferrer">
                  <img width={180} src="/static/image/footer/babu88-official.png" alt="" className="mr-3 mt-0" />
                </a>
              </div>
              <div className="row align main_title no-gutters">
                Bangladesh&apos;s No.1 - The Biggest and Most Trusted
              </div>
              <div className="row align white--text no-gutters">
                কপিরাইট © 2026 [ ব্র্যান্ড]। সমস্ত অধিকার সংরক্ষিত
              </div>
            </div>
            <div className="py-0 col col-6">
              <div className="row no-gutters">
                <label className="subtitle-1 footer-link-label">
                  <p className="main_title">আমাদের অনুসরণ করো</p>
                </label>
              </div>
              <div className="row no-gutters">
                <a href="https://www.facebook.com/babu88official/" target="_blank" rel="noreferrer">
                  <img src="/static/svg/hover_btm-fb.svg" alt="" className="footer-icon grayscale-on-hover" />
                </a>
                <a href="https://www.youtube.com/@BB88SPORTS" target="_blank" rel="noreferrer">
                  <img src="/static/svg/btm-yt.svg" alt="" className="footer-icon" />
                </a>
                <a href="https://www.instagram.com/babu88official/" target="_blank" rel="noreferrer">
                  <img src="/static/svg/hover_btm-ig.svg" alt="" className="footer-icon grayscale-on-hover" />
                </a>
                <a href="https://x.com/Babu88Official" target="_blank" rel="noreferrer">
                  <img src="/static/svg/btm-twitter.svg" alt="" className="footer-icon" />
                </a>
                <a href="https://t.me/babu88official_bd" target="_blank" rel="noreferrer">
                  <img src="/static/svg/hover_btm-tlg.svg" alt="" className="footer-icon grayscale-on-hover" />
                </a>
              </div>
            </div>
          </div>
          <div className="row no-gutters" style={{ display: 'none' }}>
            <div className="col-lg-4 col-12"></div>
          </div>
        </div>

        <div className="col col-12 paddingLR py-1">
          <div className="dotted-line py-3"></div>
        </div>

        <div className="row py-6 paddingLR second_footer no-gutters" data-footer-seo>
          <div className="col col-12">
            <h3 className="main_title pb-2">বাংলাদেশের বিশ্বস্ত অনলাইন ক্যাসিনো এবং ক্রিকেট এক্সচেঞ্জ</h3>
            <p className="seo_text">
              Babu88 হল বাংলাদেশের প্রধান অনলাইন ক্যাসিনো, মোবাইল এবং ডেস্কটপ ব্যবহারকারীদের জন্য বিভিন্ন ধরনের গেম
              অফার করে। খেলোয়াড়রা অনলাইনে আসল টাকা জেতার সুযোগ সহ রুলেট, পোকার, ব্যাকার্যাট, ব্ল্যাকজ্যাক এবং এমনকি
              ক্রিকেট এক্সচেঞ্জ বাজির বিকল্পগুলি উপভোগ করতে পারে। আমাদের প্ল্যাটফর্ম খেলোয়াড়দের জন্য দ্রুত, বিরামহীন
              গেমপ্লে এবং দুর্দান্ত বোনাস প্রদান করে। আমরা আপনার তথ্য রক্ষা করতে উন্নত এনক্রিপশন প্রযুক্তি ব্যবহার করে
              নিরাপত্তা এবং নিরাপত্তাকে অগ্রাধিকার দিই, এবং আমাদের গ্রাহক পরিষেবা 24/7 উপলব্ধ। বাংলাদেশের সেরা অনলাইন
              ক্যাসিনো গেমিং এবং ক্রিকেট এক্সচেঞ্জ বেটিং অভিজ্ঞতার জন্য আজই Babu88-এ যোগ দিন।
            </p>
          </div>

          <div className="col col-12 px-0 footer-seo-extra" id="footer-seo-extra" hidden={!seoOpen}>
            <div className="row no-gutters">
              <div className="col-lg-12 col-12">
                <div className="row mt-2 no-gutters">
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">যেই গেমগুলো পাবেন</h3>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-12">
                <div className="row mt-2 no-gutters">
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">স্লট গেম</h3>
                    <p className="seo_text">
                      BABU88 অনলাইন স্লট গেমগুলি একটি বড় ড্র। প্লেয়াররা ভিডিও স্লট, ঐতিহ্যবাহী স্লট এবং প্রগতিশীল
                      জ্যাকপট স্লটগুলির একটি আকর্ষণীয় বৈচিত্র্য উপভোগ করতে পারে। জিআইএলআই গেমস এবং প্রাগম্যাটিক প্লে-এর
                      মতো শীর্ষ প্রদানকারীর কাছ থেকে মানি কামিং, সুপার অ্যাস এবং আরও অনেক কিছুর মতো ভক্তদের পছন্দ খুঁজুন।
                    </p>
                  </div>
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">স্পোর্টস ব্যাটিং</h3>
                    <p className="seo_text">
                      ক্রীড়া উত্সাহীদের জন্য, BABU88 একটি ব্যাপক অনলাইন স্পোর্টস বেটিং প্ল্যাটফর্ম প্রদান করে।
                      খেলোয়াড়রা ফুটবল, বাস্কেটবল, টেনিস, ক্রিকেট এবং আরও অনেক কিছু সহ বিশ্বের বিভিন্ন ক্রীড়া ইভেন্টে
                      বাজি রাখতে পারে। ক্রীড়া বেটিং বিভাগটি প্রতিযোগিতামূলক প্রতিকূলতা এবং একটি ব্যবহারকারী-বান্ধব
                      ইন্টারফেস, যা খেলোয়াড়দের সুবিধামত তাদের বাজি রাখতে এবং তাদের প্রিয় দল এবং ম্যাচগুলিকে রিয়েল
                      টাইমে ট্র্যাক করতে দেয়৷ ICC, IPL, T20, BPL, LPL, CPL এবং আরও অনেক বড় টুর্নামেন্টে বাজি ধরতে আমাদের
                      ক্রিকেট এক্সচেঞ্জ ব্যবহার করুন!
                    </p>
                  </div>
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">লাইভ ক্যাসিনো গেম</h3>
                    <p className="seo_text">
                      অনলাইন ক্যাসিনো বাংলাদেশ BABU88 আপনাকে গেমের সবচেয়ে বড় স্যুট প্রদান করে যেগুলিতে আকর্ষণীয়
                      গেমপ্লে এবং জেতার পরে দুর্দান্ত পুরস্কার রয়েছে। ইভোলিউশন গেমিং (ইভো গেমিং), সুপার স্পেড গেমিং,
                      প্রাগম্যাটিক প্লে এবং এই ক্যাসিনোর মতো জনপ্রিয় বিকাশকারীরা BABU88-এ উপযোগী।
                    </p>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-12">
                <div className="row mt-2 no-gutters">
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">BABU88 এ অর্থপ্রদানের বিকল্প</h3>
                    <p className="seo_text">
                      সেরা অনলাইন ক্যাসিনো সাইটগুলি অর্থ জমা এবং উত্তোলনের বিভিন্ন উপায় অফার করে। আমরা আমাদের গ্রাহকদের
                      জন্য বিভিন্ন ধরণের অর্থপ্রদানের বিকল্প প্রদান করি, যার মধ্যে নগদ, বিকাশ, স্থানীয় ব্যাঙ্ক স্থানান্তর
                      এবং আরও অনেক কিছুর মতো পেমেন্ট চ্যানেল সহ ই-ওয়ালেট।
                    </p>
                  </div>
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">লাইসেন্স এবং নিরাপত্তা নীতি</h3>
                    <p className="seo_text">
                      BABU88 একটি নিরাপদ এবং ন্যায্য গেমিং পরিবেশ বজায় রাখার জন্য কঠোর নীতি এবং প্রবিধান অনুযায়ী কাজ
                      করে। আমরা আমাদের গেমারদের গোপনীয়তা এবং ব্যক্তিগত তথ্য সুরক্ষিত করার জন্য শক্তিশালী নিরাপত্তা
                      ব্যবস্থা রেখেছি। BABU88 দায়িত্বশীল জুয়া খেলার জন্য প্রতিশ্রুতিবদ্ধ এবং আমাদের ব্যবহারকারীদের মধ্যে
                      স্বাস্থ্যকর গেমিং অভ্যাস উন্নীত করার জন্য সরঞ্জাম এবং সংস্থান সরবরাহ করে।
                    </p>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-12">
                <div className="row mt-2 no-gutters">
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">শর্তাবলী</h3>
                    <p className="seo_text">
                      BABU88 নিয়ম ও শর্তাবলী (T&amp;C) পরিষ্কার এবং সহজবোধ্য, আমাদের প্ল্যাটফর্মের ব্যবহার নিয়ন্ত্রণ করে
                      এমন নিয়ম ও প্রবিধানের রূপরেখা। এই T&amp;Cগুলি অ্যাকাউন্ট পরিচালনা, প্রচার, আমানত, উত্তোলন এবং ব্যাটিং
                      সহ বিভিন্ন দিক কভার করে। একটি মনোরম এবং সঙ্গতিপূর্ণ গেমিং অভিজ্ঞতার নিশ্চয়তা দিতে, খেলোয়াড়দের T&amp;C
                      এর সাথে পরিচিত হওয়া উচিত।
                    </p>
                  </div>
                  <div className="col col-10 py-2">
                    <h3 className="main_title pb-2">24/7 গ্রাহক সহায়তা</h3>
                    <p className="seo_text">
                      BABU88 সার্বক্ষণিক সহায়তার গুরুত্ব বোঝে, এবং তাই, আমাদের গ্রাহক সহায়তা দিনে 24 ঘন্টা, সপ্তাহের 7
                      দিন উপলব্ধ। নিবন্ধন, সাইন আপ, জমা বা উত্তোলনের জন্য আপনার সাহায্যের প্রয়োজন হোক না কেন, BABU88
                      গ্রাহক সহায়তা আপনাকে সেবা দিতে প্রস্তুত।
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

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
        </div>
      </div>
    </footer>
  )
}
