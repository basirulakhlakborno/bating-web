import { homeMatchCards } from '../../data/homeMatches'

export function HomeMatchesHighlights() {
  return (
    <div className="row mx-0 no-gutters justify-center">
      <div className="highlights-container col col-12 pt-8 pb-3">
        <div className="matches-box">
          {homeMatchCards.map((m, idx) => (
            <div key={idx} className="match-item">
              <div className="row flex-nowrap no-gutters">
                <div className="col col-12">
                  <div tabIndex={0} className="mobile-match-card v-card v-card--link v-sheet theme--dark">
                    <div className="row">
                      <div className="ml-2 mt-2 mb-2 font-weight-bold d-flex col col-12">
                        {m.statusKind === 'live' ? (
                          <div className="matchUp">
                            <div>{m.inningsLabel}</div>
                          </div>
                        ) : (
                          <div className="matchUp-NS">
                            <div>Upcoming</div>
                          </div>
                        )}
                        <span className="ml-2 leagueName">{m.leagueName}</span>
                      </div>
                    </div>
                    <div className="row mobile-detail-wrapper no-gutters">
                      <div className="mobile-match-details match-date pl-3 pt-1 col col-12">{m.matchDate}</div>
                      {m.teams.map((t, ti) => (
                        <div key={ti} className="mobile-match-details col col-12">
                          <div className="row no-gutters">
                            <div className="d-flex align-center justify-center pa-0 col col-2">
                              <img src={t.logo} height={25} width={25} alt="" />
                            </div>
                            <div className="pa-0 col col-6">
                              <span className="team-title">{t.name}</span>
                            </div>
                            {t.score !== undefined ? (
                              <div className="pa-0 d-flex col col-4">
                                <span className="team-title">{t.score}</span>
                                {t.overs && <span className="team-title">{t.overs}</span>}
                              </div>
                            ) : null}
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
