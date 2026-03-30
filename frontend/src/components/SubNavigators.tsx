/** First block from `sub-navigators.blade.php` (menus hidden like production). */
export function SubNavigators() {
  return (
    <div
      role="menu"
      className="v-menu__content theme--light"
      style={{
        minWidth: '100% !important',
        top: 444,
        left: 0,
        transformOrigin: 'left top',
        zIndex: 17,
        display: 'none',
      }}
    >
      <div className="page-sub-navigator elevation-2">
        <div className="page-sub-navigator-wrapper">
          <div className="page-sub-navigator-item">
            <div className="elevation-0 game_card text-center align-center mr-0 v-card v-sheet theme--light">
              <div aria-label="menu" role="img" className="v-image v-responsive item-image theme--light">
                <div className="v-responsive__sizer" style={{ paddingBottom: '78.125%' }}></div>
                <div
                  className="v-image__image v-image__image--contain"
                  style={{
                    backgroundImage:
                      'url("https://jiliwin.9terawolf.com/images/babu/menu/sb/ibc_new.png")',
                    backgroundPosition: 'center center',
                  }}
                ></div>
                <div className="v-responsive__content"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
