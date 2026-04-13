import { Link } from 'react-router-dom'
import type { ReactNode } from 'react'
import type { HomeMatchCard } from '../../hooks/useSiteLayout'
import { useSiteLayout } from '../../hooks/useSiteLayout'

function MatchCardLink({ card, children }: { card: HomeMatchCard; children: ReactNode }) {
  const href = card.href?.trim() ?? ''
  if (!href) {
    return <>{children}</>
  }
  if (href.startsWith('http://') || href.startsWith('https://')) {
    return (
      <a href={href} target="_blank" rel="noopener noreferrer" className="text-decoration-none">
        {children}
      </a>
    )
  }
  return <Link to={href} className="text-decoration-none">{children}</Link>
}

export function HomeMatchesHighlights() {
  const site = useSiteLayout()
  const cards = site?.layoutHomeMatches ?? []

  if (cards.length === 0) {
    return null
  }

  return (
    <div className="row mx-0 no-gutters justify-center">
      <div className="highlights-container col col-12 pt-8 pb-3">
        <div className="matches-box">
          {cards.map((m) => (
            <div key={m.id} className="match-item">
              <div className="row flex-nowrap no-gutters">
                <div className="col col-12">
                  <MatchCardLink card={m}>
                    <div tabIndex={0} className="mobile-match-card v-card v-card--link v-sheet theme--dark">
                      <div className="row">
                        <div className="ml-2 mt-2 mb-2 font-weight-bold d-flex col col-12">
                          {m.statusKind === 'live' ? (
                            <div className="matchUp">
                              <div>{m.inningsLabel ?? 'Live'}</div>
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
                                {t.logo ? <img src={t.logo} height={25} width={25} alt="" /> : null}
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
                  </MatchCardLink>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
