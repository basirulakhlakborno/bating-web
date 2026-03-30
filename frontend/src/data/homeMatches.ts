/** Cricket match cards from `partials/home/bg-filter.blade.php` (matches-box). */
export type HomeMatchTeamRow = {
  logo: string
  name: string
  score?: string
  overs?: string
}

export type HomeMatchCard = {
  statusKind: 'live' | 'upcoming'
  /** e.g. "2nd Innings" — only for live */
  inningsLabel?: string
  leagueName: string
  matchDate: string
  teams: [HomeMatchTeamRow, HomeMatchTeamRow]
}

export const homeMatchCards: HomeMatchCard[] = [
  {
    statusKind: 'live',
    inningsLabel: '2nd Innings',
    leagueName: 'One Day International Women',
    matchDate: 'Mar 29, 2026 07:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/15/79.png', name: 'New Zealand W', score: '268', overs: '/ 10 (50)' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/9/73.png', name: 'South Africa W', score: '82', overs: '/ 2 (14.2)' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: "ICC Men's T20 World Cup Regional Qualifications",
    matchDate: 'Mar 29, 2026 15:30:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/10/2282.png', name: 'Seychelles' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/16/2288.png', name: 'Eswatini' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'Pakistan Super League',
    matchDate: 'Mar 29, 2026 15:30:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/20/3060.png', name: 'Hyderabad Kingsmen' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/16/16.png', name: 'Quetta Gladiators' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'CSA One Day Cup',
    matchDate: 'Mar 29, 2026 17:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/0/64.png', name: 'Lions' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/28/60.png', name: 'Titans' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: "ICC Men's T20 World Cup Regional Qualifications",
    matchDate: 'Mar 29, 2026 19:50:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/7/2279.png', name: 'Saint Helena' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/1/2273.png', name: 'Malawi' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: "ICC Men's T20 World Cup Regional Qualifications",
    matchDate: 'Mar 29, 2026 19:50:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/22/2294.png', name: 'Ghana' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/15/2255.png', name: 'Tanzania' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'Indian Premier League',
    matchDate: 'Mar 29, 2026 20:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/6/6.png', name: 'Mumbai Indians' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/5/5.png', name: 'Kolkata Knight Riders' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'Pakistan Super League',
    matchDate: 'Mar 29, 2026 20:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/13/13.png', name: 'Lahore Qalandars' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/12/12.png', name: 'Karachi Kings' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'One Day International Women',
    matchDate: 'Mar 30, 2026 00:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/11/75.png', name: 'West Indies W' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/13/77.png', name: 'Australia W' },
    ],
  },
  {
    statusKind: 'upcoming',
    leagueName: 'Indian Premier League',
    matchDate: 'Mar 30, 2026 20:00:00',
    teams: [
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/7/7.png', name: 'Rajasthan Royals' },
      { logo: 'https://cdn.sportmonks.com/images/cricket/teams/2/2.png', name: 'Chennai Super Kings' },
    ],
  },
]
