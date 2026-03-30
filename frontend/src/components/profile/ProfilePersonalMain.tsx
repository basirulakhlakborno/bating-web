export type ProfilePersonalFields = {
  username: string
  currency: string
  fullName: string
  birthDate: string
  email: string
  phoneMasked: string
  street: string
  city: string
  subdistrict: string
  district: string
  postcode: string
}

function EditProfileIcon() {
  return (
    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" aria-hidden>
      <path
        fill="currentColor"
        d="M20.993 3.183c-.046.178-.079.356-.132.534a3.081 3.081 0 01-.784 1.252q-4.843 4.843-9.693 9.686a1.419 1.419 0 01-.507.323c-1.417.488-2.84.949-4.263 1.43a.83.83 0 01-.784-.066.779.779 0 01-.25-.936c.369-1.107.778-2.2 1.094-3.321a4.9 4.9 0 011.371-2.214c2.965-2.919 5.9-5.864 8.83-8.81a3.21 3.21 0 011.9-1.041h.692a2.82 2.82 0 012.306 1.957 5.537 5.537 0 01.138.547c-.01.211-.01.428-.01.646z"
      />
      <path
        fill="currentColor"
        d="M.013 11.215V3.776a2.233 2.233 0 011.845-2.254 2.635 2.635 0 01.507-.04h8.751c.514 0 .83.244.87.672a.729.729 0 01-.7.817H2.418a1.33 1.33 0 00-.362.04.71.71 0 00-.534.626 3.332 3.332 0 00-.013.264v14.628a2.04 2.04 0 00.013.283.721.721 0 00.633.626 1.767 1.767 0 00.264.013H15.57c.072 0 .152 0 .224-.007a.721.721 0 00.685-.712c.013-.283.007-.573.007-.863v-6.5a1.511 1.511 0 01.053-.422.738.738 0 011.41.053 1.187 1.187 0 01.033.3c0 2.438.007 4.876 0 7.314a2.246 2.246 0 01-1.746 2.26 2.333 2.333 0 01-.567.059H2.313A2.24 2.24 0 010 18.628c.013-2.451.013-4.935.013-7.413z"
      />
    </svg>
  )
}

const warnIcon = 'https://babu88.gold/static/svg/personal-info-warning.svg'

function FieldRowDesktop({
  label,
  value,
  empty,
  pb,
}: {
  label: string
  value: string
  empty?: boolean
  pb?: 'pb-2' | 'pb-5'
}) {
  return (
    <div className={`row hidden-sm-and-down ${pb ?? 'pb-2'} no-gutters align-end profile-field-row`}>
      <div className="pb-2 col-12 col-md-4 col-lg-5">
        <label className="field-name-desktop">{label}</label>
      </div>
      <div className={`pa-2 col-12 col-md-8 col-lg-7 ${empty ? 'empty-label' : 'filled-label'}`}>
        <label className="profile-field-value">{value}</label>
      </div>
    </div>
  )
}

export function ProfilePersonalMain({ f }: { f: ProfilePersonalFields }) {
  return (
    <div className="v-card v-sheet theme--light mobile_profile_card">
          <div className="v-card__title profile-card-title-row">
            <label className="--v-primary-base text-left text-capitalize mr-4">আমার প্রোফাইল</label>
            <button type="button" className="icon-btn v-btn v-btn--icon v-btn--round theme--light v-size--default" aria-label="সম্পাদনা">
              <span className="v-btn__content">
                <EditProfileIcon />
              </span>
            </button>
          </div>

          <div className="profile-detail-card v-card v-sheet theme--light elevation-1">
            <FieldRowDesktop label="ব্যবহারকারীর নাম" value={f.username} pb="pb-5" />
            <FieldRowDesktop label="জন্ম তারিখ" value={f.birthDate} empty={!f.birthDate} />
            <FieldRowDesktop label="পুরো নাম" value={f.fullName} empty={!f.fullName} />
            <div className="row hidden-sm-and-down mb-4 no-gutters align-end profile-field-row">
              <div className="pb-2 col-12 col-md-4 col-lg-5">
                <label className="field-name-desktop">মুদ্রা</label>
              </div>
              <div className="pa-2 col-12 col-md-8 col-lg-7 filled-label">
                <label className="profile-field-value">{f.currency}</label>
              </div>
            </div>

            <div className="row hidden-sm-and-down d-flex flex-column no-gutters profile-section-gap">
              <div className="v-card__title hidden-sm-and-down px-0 pb-5 profile-section-title">
                <label className="--v-primary-base text-left text-capitalize profile-txt">যোগাযোগের ঠিকানা</label>
                <button type="button" className="icon-btn v-btn v-btn--icon v-btn--round theme--light v-size--default" aria-label="ঠিকানা সম্পাদনা">
                  <span className="v-btn__content">
                    <EditProfileIcon />
                  </span>
                </button>
              </div>
              <FieldRowDesktop label="বাড়ি / রাস্তা" value={f.street} empty={!f.street} />
              <FieldRowDesktop label="শহর" value={f.city} empty={!f.city} />
              <FieldRowDesktop label="থানা / উপজেলা" value={f.subdistrict} empty={!f.subdistrict} />
              <FieldRowDesktop label="জেলা" value={f.district} empty={!f.district} />
              <FieldRowDesktop label="পোস্ট কোড" value={f.postcode} empty={!f.postcode} />
              <FieldRowDesktop label="ইমেল ঠিকানা" value={f.email} empty={!f.email} />
            </div>
            <div className="row hidden-sm-and-down no-gutters align-end profile-field-row profile-phone-desktop profile-section-gap">
              <div className="pb-2 col-12 col-md-4 col-lg-5">
                <label className="field-name-desktop">প্রাইমারি নম্বর</label>
              </div>
              <div className="pa-2 mb-4 phoneNo col-12 col-md-8 col-lg-7 filled-label">
                <label className="profile-field-value">{f.phoneMasked}</label>
                <div className="phoneVerificationStatus">
                  <div className="v-image v-responsive theme--light" style={{ height: 25, width: 25 }}>
                    <div className="v-responsive__sizer" style={{ paddingBottom: '100%' }}></div>
                    <div
                      className="v-image__image v-image__image--contain"
                      style={{ backgroundImage: `url("${warnIcon}")`, backgroundPosition: 'center center' }}
                    ></div>
                  </div>
                </div>
                <label className="verifyOTPTxt">OTP যাচাই করুন</label>
              </div>
            </div>

            {/* Mobile */}
            <div className="row px-3 px-sm-4 pb-2 pt-4 pt-sm-6 hidden-md-and-up no-gutters align-end">
              <div className="col col-12">
                <div className="row new-mobile-username-gap no-gutters">
                  <div className="pb-2 col-sm-7 col-md-9 col-7">
                    <label className="field-name-desktop-desktop">ব্যবহারকারীর নাম</label>
                  </div>
                  <div className="pb-2 col-sm-4 col-md-2 col-4">
                    <label className="field-name-desktop-desktop">মুদ্রা</label>
                  </div>
                </div>
              </div>
              <div className="col col-12">
                <div className="row new-mobile-username-gap no-gutters">
                  <div className="pa-2 col-sm-7 col-md-9 col-7 filled-label">
                    <label>{f.username}</label>
                  </div>
                  <div className="pa-2 filled-label col-sm-4 col-md-2 col-4">
                    <label className="field-name-desktop-desktop">{f.currency}</label>
                  </div>
                </div>
              </div>
            </div>
            <div className="row px-3 px-sm-4 pa-2 hidden-md-and-up no-gutters align-end profile-mobile-section-gap">
              <div className="pb-2 col col-12">
                <label className="field-name-desktop">পুরো নাম</label>
              </div>
              <div className="pa-2 filled-label col col-12">
                <label className="profile-field-value">{f.fullName}</label>
              </div>
            </div>
            <div className="row px-3 px-sm-4 pa-2 hidden-md-and-up no-gutters align-end profile-mobile-field-gap">
              <div className="pb-2 col col-12">
                <label className="field-name-desktop">ইমেইল</label>
              </div>
              <div className="pa-2 filled-label col col-12">
                <label className="profile-field-value">{f.email}</label>
              </div>
            </div>
            <div className="row px-3 px-sm-4 pa-2 hidden-md-and-up no-gutters align-end profile-mobile-field-gap">
              <div className="pb-2 col col-12">
                <label className="field-name-desktop">জন্ম তারিখ</label>
              </div>
              <div className="pa-2 filled-label col col-12">
                <label className="profile-field-value">{f.birthDate}</label>
              </div>
            </div>
            <div className="row px-3 px-sm-4 pa-2 hidden-md-and-up no-gutters profile-mobile-field-gap profile-mobile-phone-block">
              <div className="col col-12 pb-2">
                <label className="field-name-desktop">প্রাইমারি নম্বর</label>
              </div>
              <div className="col col-12">
                <div className="profile-mobile-phone-inner">
                  <div className="filled-label pa-2">
                    <label className="profile-field-value">{f.phoneMasked}</label>
                  </div>
                  <div className="m-phoneVerificationStatus">
                    <div className="v-image v-responsive theme--light" style={{ height: 20, width: 25 }}>
                      <div className="v-responsive__sizer" style={{ paddingBottom: '100%' }}></div>
                      <div
                        className="v-image__image v-image__image--contain"
                        style={{ backgroundImage: `url("${warnIcon}")`, backgroundPosition: 'center center' }}
                      ></div>
                    </div>
                    <label className="verifyOTPTxt">OTP যাচাই করুন</label>
                  </div>
                </div>
              </div>
            </div>
            <div className="row breakpoint no-gutters align-end px-3 px-sm-4 pa-2 pt-0">
              <div className="pt-0 col-12">
                <button type="button" className="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default add-mobile-btn-mobile profile-mobile-secondary-btn">
                  <span className="v-btn__content">সেকেন্ডারি নম্বর যোগ করুন</span>
                </button>
              </div>
            </div>

            <div className="row hidden-md-and-up d-flex flex-column no-gutters px-3 px-sm-4 profile-mobile-section-gap">
              <div className="v-card__title hidden-md-and-up px-0 pt-2 profile-section-title">
                <label className="--v-primary-base text-left text-capitalize profile-txt">যোগাযোগের ঠিকানা</label>
                <button type="button" className="icon-btn v-btn v-btn--icon v-btn--round theme--light v-size--default" aria-label="ঠিকানা সম্পাদনা">
                  <span className="v-btn__content">
                    <EditProfileIcon />
                  </span>
                </button>
              </div>
              {[
                { k: 'বাড়ি / রাস্তা', v: f.street },
                { k: 'শহর', v: f.city },
                { k: 'থানা / উপজেলা', v: f.subdistrict },
                { k: 'জেলা', v: f.district },
                { k: 'পোস্ট কোড', v: f.postcode, last: true },
              ].map((row) => (
                <div
                  key={row.k}
                  className={`row px-3 px-sm-4 pa-3 pa-sm-4 hidden-md-and-up no-gutters align-end profile-mobile-address-row${row.last ? ' mb-4' : ''}`}
                >
                  <div className="col-12 col-sm-4 col-md-3">
                    <label className="field-name">{row.k}</label>
                  </div>
                  <div className="col-12 col-sm-8 col-md-9">
                    <label className="profile-field-value">{row.v}</label>
                  </div>
                  <div className="col col-12 mt-2">
                    <hr role="separator" aria-orientation="horizontal" className="v-divider theme--light" />
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="row no-gutters align-center profile-footer-notice">
            <div className="text-left mobile-subtitle ma-2 mx-3 mx-sm-4 mb-4 col col-12">
              আপনার গোপনীয়তা রক্ষা করতে, আপনার প্রোফাইলের বিবরণ পরিবর্তন করতে আমাদের গ্রাহক পরিষেবার সাথে যোগাযোগ করুন
            </div>
          </div>
        </div>
  )
}
