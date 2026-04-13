<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCricketMatch extends Model
{
    protected $fillable = [
        'status',
        'innings_label',
        'league_name',
        'match_starts_at',
        'team1_name',
        'team1_logo_path',
        'team1_score',
        'team1_overs',
        'team2_name',
        'team2_logo_path',
        'team2_score',
        'team2_overs',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'match_starts_at' => 'datetime',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Shape expected by the React homepage matches strip.
     *
     * @return array<string, mixed>
     */
    public function toPlayerCard(): array
    {
        $card = [
            'id' => $this->id,
            'statusKind' => $this->status,
            'leagueName' => $this->league_name,
            'matchDate' => $this->match_starts_at !== null
                ? $this->match_starts_at->format('M j, Y H:i:s')
                : '',
            'teams' => [
                $this->teamRow(
                    $this->team1_logo_path,
                    $this->team1_name,
                    $this->team1_score,
                    $this->team1_overs,
                ),
                $this->teamRow(
                    $this->team2_logo_path,
                    $this->team2_name,
                    $this->team2_score,
                    $this->team2_overs,
                ),
            ],
        ];

        if ($this->status === 'live' && $this->innings_label !== null && $this->innings_label !== '') {
            $card['inningsLabel'] = $this->innings_label;
        }

        if ($this->link_url !== null && trim($this->link_url) !== '') {
            $card['href'] = trim($this->link_url);
        }

        return $card;
    }

    /**
     * @return array<string, string>
     */
    private function teamRow(?string $logoPath, string $name, ?string $score, ?string $overs): array
    {
        $row = [
            'logo' => self::publicLogoUrl($logoPath),
            'name' => $name,
        ];
        if ($score !== null && $score !== '') {
            $row['score'] = $score;
        }
        if ($overs !== null && $overs !== '') {
            $row['overs'] = $overs;
        }

        return $row;
    }

    private static function publicLogoUrl(?string $path): string
    {
        $path = $path !== null ? trim($path) : '';
        if ($path === '') {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
