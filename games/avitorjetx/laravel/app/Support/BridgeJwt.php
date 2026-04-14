<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Validates JWTs issued by the main Babu88 app (same HMAC secret as App\Support\JwtToken there).
 */
class BridgeJwt
{
    private static function b64UrlDecode(string $value): string
    {
        $pad = strlen($value) % 4;
        if ($pad > 0) {
            $value .= str_repeat('=', 4 - $pad);
        }

        return base64_decode(strtr($value, '-_', '+/')) ?: '';
    }

    private static function b64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    /**
     * Must match {@see \App\Support\JwtToken} on the main Babu88 app.
     * Prefer ROOT_BRIDGE_JWT_SECRET in this app's .env; otherwise the same JWT_SECRET value as the main app.
     */
    private static function decodeIfBase64(string $value): string
    {
        if (str_starts_with($value, 'base64:')) {
            $decoded = base64_decode(substr($value, 7), true);
            if ($decoded !== false) {
                return $decoded;
            }
        }

        return $value;
    }

    private static function secret(): string
    {
        $bridge = trim((string) config('services.root_app.bridge_jwt_secret', ''));
        if ($bridge !== '') {
            return self::decodeIfBase64($bridge);
        }

        $fromJwtEnv = (string) env('JWT_SECRET', '');
        if ($fromJwtEnv !== '') {
            return self::decodeIfBase64($fromJwtEnv);
        }

        return self::decodeIfBase64((string) config('app.key', ''));
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function decode(string $jwt): ?array
    {
        if (self::secret() === '') {
            return null;
        }

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

    /**
     * Structured check for debugging (probe API). Never includes the signing secret.
     *
     * @return array{ok: bool, reason?: string, exp?: int, signing_secret_configured: bool, payload?: array<string, mixed>, claims_preview?: array<string, mixed>, hint?: string}
     */
    public static function probe(string $jwt): array
    {
        $jwt = trim($jwt);
        $secretConfigured = self::secret() !== '';

        if ($jwt === '') {
            return [
                'ok' => false,
                'reason' => 'empty_token',
                'signing_secret_configured' => $secretConfigured,
            ];
        }

        if (! $secretConfigured) {
            return [
                'ok' => false,
                'reason' => 'missing_signing_secret',
                'signing_secret_configured' => false,
                'hint' => 'Set ROOT_BRIDGE_JWT_SECRET or JWT_SECRET (same as main Babu88 JwtToken signing key).',
            ];
        }

        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return [
                'ok' => false,
                'reason' => 'malformed_not_three_segments',
                'signing_secret_configured' => true,
            ];
        }

        [$h, $p, $s] = $parts;
        $expected = self::b64UrlEncode(hash_hmac('sha256', $h.'.'.$p, self::secret(), true));
        if (! hash_equals($expected, $s)) {
            return [
                'ok' => false,
                'reason' => 'bad_signature_or_wrong_secret',
                'signing_secret_configured' => true,
                'hint' => 'Secret on this app does not match the key used to sign the token on the main site.',
            ];
        }

        $payload = json_decode(self::b64UrlDecode($p), true);
        if (! is_array($payload)) {
            return [
                'ok' => false,
                'reason' => 'invalid_payload_json',
                'signing_secret_configured' => true,
            ];
        }

        if (isset($payload['exp']) && is_numeric($payload['exp']) && (int) $payload['exp'] < Carbon::now()->timestamp) {
            return [
                'ok' => false,
                'reason' => 'expired',
                'exp' => (int) $payload['exp'],
                'signing_secret_configured' => true,
            ];
        }

        $sub = (string) ($payload['sub'] ?? '');
        $username = (string) ($payload['username'] ?? '');
        if ($sub === '' || $username === '') {
            return [
                'ok' => false,
                'reason' => 'missing_sub_or_username',
                'signing_secret_configured' => true,
                'claims_preview' => [
                    'sub' => $sub !== '' ? $sub : null,
                    'username' => $username !== '' ? $username : null,
                ],
            ];
        }

        return [
            'ok' => true,
            'signing_secret_configured' => true,
            'payload' => $payload,
            'claims_preview' => [
                'sub' => $sub,
                'username' => $username,
                'email' => $payload['email'] ?? null,
                'name' => $payload['name'] ?? null,
                'phone' => $payload['phone'] ?? null,
                'balance' => $payload['balance'] ?? null,
                'exp' => $payload['exp'] ?? null,
                'iat' => $payload['iat'] ?? null,
                'iss' => $payload['iss'] ?? null,
            ],
        ];
    }
}
