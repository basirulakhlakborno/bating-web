<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Contracts\View\View;

class GameEmbedController extends Controller
{
    public function show(Game $game): View
    {
        if (! $game->is_active || ! $game->opens_in_iframe) {
            abort(404);
        }

        $base = rtrim((string) $game->iframe_remote_base, '/');
        if ($base === '') {
            $base = rtrim((string) config('services.aviator.public_url', ''), '/');
        }
        if ($base === '') {
            abort(503, 'Remote game URL is not set. Add AVIATOR_PUBLIC_URL to .env or set “Remote game base URL” on this game in admin.');
        }

        $bridge = trim((string) ($game->iframe_bridge_path ?: 'game-bridge'), '/');
        if ($bridge === '') {
            $bridge = 'game-bridge';
        }

        /** Full URL to the remote game bridge (no query string). */
        $gameBridgeUrl = $base.'/'.ltrim($bridge, '/');

        return view('games.play-embed', [
            'pageTitle' => $game->title,
            'gameBridgeUrl' => $gameBridgeUrl,
            'minimalChrome' => true,
        ]);
    }
}
