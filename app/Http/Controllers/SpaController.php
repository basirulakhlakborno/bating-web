<?php

namespace App\Http\Controllers;

use App\Services\SiteLayoutData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Serves the React SPA via a Blade template that reads the Vite manifest
 * and injects server-side data (site title, footer, nav, CSRF token, etc.).
 */
class SpaController extends Controller
{
    public function __invoke(Request $request): View|\Illuminate\Http\Response
    {
        if (! $request->isMethod('GET')) {
            abort(405);
        }

        $manifestPath = public_path('dist/.vite/manifest.json');
        if (! is_file($manifestPath)) {
            return response(
                'SPA not built. From the frontend folder run: npm ci && npm run build',
                503,
                ['Content-Type' => 'text/plain; charset=UTF-8'],
            );
        }

        $siteData = SiteLayoutData::shared();

        return view('spa', [
            'siteData' => $siteData,
        ]);
    }
}
