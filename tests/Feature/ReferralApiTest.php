<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\JwtToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferralApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_referral_returns_401_without_bearer_token(): void
    {
        $this->getJson('/api/referral')
            ->assertStatus(401)
            ->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function test_referral_returns_dashboard_shape_with_valid_jwt(): void
    {
        $user = User::factory()->create();

        $token = JwtToken::issue([
            'sub' => (string) $user->getKey(),
            'username' => (string) $user->username,
            'role' => 'user',
        ], 120);

        $res = $this->getJson('/api/referral', [
            'Authorization' => 'Bearer '.$token,
        ]);

        $res->assertOk()
            ->assertJsonStructure([
                'meta' => ['title_bn', 'description_bn', 'referral_code', 'share_url'],
                'tiers',
                'summary' => [
                    'currency_code',
                    'currency_symbol',
                    'total_commission',
                    'total_bonus',
                    'total_referral_income',
                    'tier_count',
                    'pending_settlement',
                    'last_settled_at',
                ],
                'report' => ['period_days', 'currency_code', 'rows', 'period_total'],
                'history' => ['limit', 'rows'],
            ]);

        $data = $res->json();
        $this->assertIsArray($data['tiers']);
        $this->assertGreaterThan(0, count($data['tiers']));
        $this->assertSame($user->publicReferralCode(), $data['meta']['referral_code']);
    }
}
