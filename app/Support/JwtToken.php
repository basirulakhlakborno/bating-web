<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class JwtToken
{
    private static function b64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private static function b64UrlDecode(string $value): string
    {
        $pad = strlen($value) % 4;
        if ($pad > 0) {
            $value .= str_repeat('=', 4 - $pad);
        }

        return base64_decode(strtr($value, '-_', '+/')) ?: '';
    }

    private static function secret(): string
    {
        $fromEnv = (string) env('JWT_SECRET', '');
        if ($fromEnv !== '') {
            return $fromEnv;
        }

        $appKey = (string) config('app.key', '');
        if (str_starts_with($appKey, 'base64:')) {
            $decoded = base64_decode(substr($appKey, 7), true);
            if ($decoded !== false) {
                return $decoded;
            }
        }

        return $appKey;
    }

    public static function issue(array $claims, int $ttlMinutes = 120): string
    {
        $now = Carbon::now()->timestamp;
        $payload = array_merge($claims, [
            'iat' => $now,
            'exp' => $now + max(1, $ttlMinutes) * 60,
            'iss' => (string) config('app.url'),
        ]);

        $headerPart = self::b64UrlEncode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']) ?: '{}');
        $payloadPart = self::b64UrlEncode(json_encode($payload) ?: '{}');
        $signingInput = $headerPart.'.'.$payloadPart;
        $signature = hash_hmac('sha256', $signingInput, self::secret(), true);

        return $signingInput.'.'.self::b64UrlEncode($signature);
    }

    public static function decode(string $jwt): ?array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        [$h, $p, $s] = $parts;
        $expected = self::b64UrlEncode(hash_hmac('sha256', $h.'.'.$p, self::secret(), true));
        if (! hash_equals($expected, $s)) {
            return null;
        }

        $payload = json_decode(self::b64UrlDecode($p), true);
        if (! is_array($payload)) {
            return null;
        }

        if (isset($payload['exp']) && is_numeric($payload['exp']) && (int) $payload['exp'] < Carbon::now()->timestamp) {
            return null;
        }

        return $payload;
    }
}

