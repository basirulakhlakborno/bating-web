<?php

namespace App\Http\Middleware;

use App\Services\SiteLayoutData;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearLayoutCache
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethodSafe()) {
            SiteLayoutData::clearCache();
        }

        return $response;
    }
}
