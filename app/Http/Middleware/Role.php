<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
  /**
  * Get the path the user should be redirected to when they are not authenticated.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return string|null
  */
  public function handle($request, Closure $next, $type)
  {
    if(Auth::user() &&  Auth::user()->role_id == 1 && $type == 'superadmin')
    {
      return $next($request);
    }
    elseif(Auth::user() &&  Auth::user()->role_id == 2 && $type == 'admin')
    {
      return $next($request);
    }
    elseif(Auth::user() &&  Auth::user()->role_id == 6 && $type == 'customer')
    {
      return $next($request);
    }
    else
    {
      abort(403, 'Unauthorized action.');
    }
  }
}
