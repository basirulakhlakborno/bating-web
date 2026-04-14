<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameEmbedController extends Controller
{
    public function show(Request $request, int $id): Response|\Illuminate\Contracts\View\View
    {
        $game = Game::find($id);

        if (! $game || ! $game->is_active || ! $game->opens_in_iframe) {
            return response('Game not available.', 404, ['Content-Type' => 'text/plain']);
        }

        $base = rtrim((string) $game->iframe_remote_base, '/');
        if ($base === '') {
            $base = rtrim((string) config('services.aviator.public_url', ''), '/');
        }
        if ($base === '') {
            return response('Game URL not configured.', 503, ['Content-Type' => 'text/plain']);
        }

        // cPanel/shared hosting blocks URLs containing /laravel/ (ModSecurity).
        // The parent directory's index.php serves the same Laravel app, so strip the suffix.
        $base = preg_replace('#/laravel/public$#', '', $base);

        $bridge = trim((string) ($game->iframe_bridge_path ?: 'game-bridge'), '/');
        if ($bridge === '') {
            $bridge = 'game-bridge';
        }

        $gameBridgeUrl = $base.'/'.ltrim($bridge, '/');

        return view('games.play-embed', [
            'pageTitle' => $game->title,
            'gameBridgeUrl' => $gameBridgeUrl,
            'minimalChrome' => true,
        ]);
    }
}
