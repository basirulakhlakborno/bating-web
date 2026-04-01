<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Serves the Vite-built React SPA (`public/dist/index.html`) for all guest/player GET routes.
 * Run `npm run build` in `/frontend`; assets live under `/dist/*`.
 */
class SpaController extends Controller
{
    private function indexPath(): string
    {
        return public_path('dist/index.html');
    }

    public function __invoke(Request $request): BinaryFileResponse|\Illuminate\Http\Response
    {
        if (! $request->isMethod('GET')) {
            abort(405);
        }

        $path = $this->indexPath();
        if (! is_file($path)) {
            return response(
                'SPA not built. From the frontend folder run: npm ci && npm run build',
                503,
                ['Content-Type' => 'text/plain; charset=UTF-8'],
            );
        }

        return response()->file($path, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Cache-Control' => 'no-cache, private',
        ]);
    }
}
