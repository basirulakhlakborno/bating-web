<?php

namespace Database\Seeders;

use App\Models\HomeCricketMatch;
use Illuminate\Database\Seeder;

class HomeCricketMatchSeeder extends Seeder
{
    public function run(): void
    {
        if (HomeCricketMatch::query()->exists()) {
            return;
        }

        $rows = [
            [
                'status' => 'live',
                'innings_label' => '2nd Innings',
                'league_name' => 'One Day International Women',
                'match_starts_at' => '2026-03-29 07:00:00',
                'team1_name' => 'New Zealand W',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/15/79.png',
                'team1_score' => '268',
                'team1_overs' => '/ 10 (50)',
                'team2_name' => 'South Africa W',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/9/73.png',
                'team2_score' => '82',
                'team2_overs' => '/ 2 (14.2)',
                'sort_order' => 0,
            ],
            [
                'status' => 'upcoming',
                'innings_label' => null,
                'league_name' => "ICC Men's T20 World Cup Regional Qualifications",
                'match_starts_at' => '2026-03-29 15:30:00',
                'team1_name' => 'Seychelles',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/10/2282.png',
                'team2_name' => 'Eswatini',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/16/2288.png',
                'sort_order' => 1,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'Pakistan Super League',
                'match_starts_at' => '2026-03-29 15:30:00',
                'team1_name' => 'Hyderabad Kingsmen',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/20/3060.png',
                'team2_name' => 'Quetta Gladiators',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/16/16.png',
                'sort_order' => 2,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'CSA One Day Cup',
                'match_starts_at' => '2026-03-29 17:00:00',
                'team1_name' => 'Lions',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/0/64.png',
                'team2_name' => 'Titans',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/28/60.png',
                'sort_order' => 3,
            ],
            [
                'status' => 'upcoming',
                'league_name' => "ICC Men's T20 World Cup Regional Qualifications",
                'match_starts_at' => '2026-03-29 19:50:00',
                'team1_name' => 'Saint Helena',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/7/2279.png',
                'team2_name' => 'Malawi',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/1/2273.png',
                'sort_order' => 4,
            ],
            [
                'status' => 'upcoming',
                'league_name' => "ICC Men's T20 World Cup Regional Qualifications",
                'match_starts_at' => '2026-03-29 19:50:00',
                'team1_name' => 'Ghana',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/22/2294.png',
                'team2_name' => 'Tanzania',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/15/2255.png',
                'sort_order' => 5,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'Indian Premier League',
                'match_starts_at' => '2026-03-29 20:00:00',
                'team1_name' => 'Mumbai Indians',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/6/6.png',
                'team2_name' => 'Kolkata Knight Riders',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/5/5.png',
                'sort_order' => 6,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'Pakistan Super League',
                'match_starts_at' => '2026-03-29 20:00:00',
                'team1_name' => 'Lahore Qalandars',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/13/13.png',
                'team2_name' => 'Karachi Kings',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/12/12.png',
                'sort_order' => 7,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'One Day International Women',
                'match_starts_at' => '2026-03-30 00:00:00',
                'team1_name' => 'West Indies W',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/11/75.png',
                'team2_name' => 'Australia W',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/13/77.png',
                'sort_order' => 8,
            ],
            [
                'status' => 'upcoming',
                'league_name' => 'Indian Premier League',
                'match_starts_at' => '2026-03-30 20:00:00',
                'team1_name' => 'Rajasthan Royals',
                'team1_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/7/7.png',
                'team2_name' => 'Chennai Super Kings',
                'team2_logo_path' => 'https://cdn.sportmonks.com/images/cricket/teams/2/2.png',
                'sort_order' => 9,
            ],
        ];

        foreach ($rows as $row) {
            HomeCricketMatch::query()->create(array_merge([
                'link_url' => null,
                'is_active' => true,
            ], $row));
        }
    }
}
