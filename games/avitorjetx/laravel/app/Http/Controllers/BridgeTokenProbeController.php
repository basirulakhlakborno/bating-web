<?php

namespace App\Http\Controllers;

use App\Support\BridgeJwt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Debug-only: verify a main-site bridge JWT using the same rules as /game-bridge.
 *
 * Enabled when APP_DEBUG=true or BRIDGE_TOKEN_PROBE_ENABLED=true in .env.
 */
class BridgeTokenProbeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if (! config('app.debug') && ! filter_var(env('BRIDGE_TOKEN_PROBE_ENABLED', false), FILTER_VALIDATE_BOOLEAN)) {
            abort(404);
        }

        $token = (string) (
            $request->bearerToken()
            ?? $request->query('token')
            ?? $request->input('token')
            ?? ''
        );

        $result = BridgeJwt::probe($token);

        return response()->json($result, $result['ok'] ? 200 : 422);
    }
}
