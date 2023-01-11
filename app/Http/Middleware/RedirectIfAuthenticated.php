<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        dd(auth()->user());

        foreach ($guards as $guard) {
            if ($guard == "admin" && Auth::guard($guard)->check()) {
                return redirect('/admin/dashboard');
            }
            if ($guard == "seller" && Auth::guard($guard)->check()) {
                return redirect('/seller');
            }
            if (Auth::guard($guard)->check()) {
                return redirect('/home');
            }

        }

        return $next($request);
    }
//    public function handle($request, Closure $next, $guard = null)
//        {
//            if ($guard == "admin" && Auth::guard($guard)->check()) {
//                return redirect('/admin');
//            }
//            if ($guard == "seller" && Auth::guard($guard)->check()) {
//                return redirect('/seller');
//            }
//            if (Auth::guard($guard)->check()) {
//                return redirect('/home');
//            }
//    
//            return $next($request);
//        }
}
