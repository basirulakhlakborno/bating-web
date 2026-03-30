<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $path = $request->path();

        if (preg_match('/\.(css|js|woff2?|ttf|eot|svg|png|jpe?g|gif|webp|ico)$/i', $path)) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        } else {
            $response->headers->set('Cache-Control', 'public, max-age=300, must-revalidate');
        }

        return $response;
    }
}
