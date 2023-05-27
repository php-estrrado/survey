<?php

namespace App\Http\Middleware;

use Closure;

class SetXFrameOptions
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
         if(method_exists($response, 'header'))
        {
            
        }
        else
        {
            // $response->header('X-Frame-Options', 'SAMEORIGIN');

            return $response;
        }
        
        $response->header('X-Frame-Options', 'SAMEORIGIN');

            return $response;
        
        
    }
}