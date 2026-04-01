<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use App\Support\JwtToken;
use Illuminate\Http\Request;

trait ResolvesJwtUser
{
    protected function resolveBearerUser(Request $request): ?User
    {
        $header = (string) $request->header('Authorization', '');
        if (! preg_match('/^Bearer\s+(.+)$/i', $header, $matches)) {
            return null;
        }

        $payload = JwtToken::decode((string) $matches[1]);
        $uid = is_array($payload) ? ($payload['sub'] ?? null) : null;
        if (! $uid) {
            return null;
        }

        /** @var User|null $user */
        $user = User::query()->find($uid);

        return $user;
    }
}
