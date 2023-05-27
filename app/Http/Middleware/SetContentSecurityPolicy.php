<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';";

        $response->header('Content-Security-Policy', $csp);

        return $response;
    }
}
