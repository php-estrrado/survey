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
    elseif(Auth::user() &&  Auth::user()->role_id == 3 && $type == 'surveyor')
    {
      return $next($request);
    }
    elseif(Auth::user() &&  Auth::user()->role_id == 4 && $type == 'draftsman')
    {
      return $next($request);
    }
    elseif(Auth::user() &&  Auth::user()->role_id == 5 && $type == 'accountant')
    {
      return $next($request);
    }
    elseif(Auth::user() &&  Auth::user()->role_id == 6 && $type == 'customer')
    {
      return $next($request);
    }
    else
    {
      if(Auth::user() &&  Auth::user()->role_id != 1 && $type == 'superadmin')
      {
        return redirect('superadmin/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      elseif(Auth::user() &&  Auth::user()->role_id != 2 && $type == 'admin')
      {
        return redirect('admin/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      elseif(Auth::user() &&  Auth::user()->role_id != 3 && $type == 'surveyor')
      {
        return redirect('surveyor/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      elseif(Auth::user() &&  Auth::user()->role_id != 4 && $type == 'draftsman')
      {
        return redirect('draftsman/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      elseif(Auth::user() &&  Auth::user()->role_id != 5 && $type == 'accounts')
      {
        return redirect('accountant/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      elseif(Auth::user() &&  Auth::user()->role_id != 6 && $type == 'customer')
      {
        return redirect('customer/login')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
      }
      else
      {
        abort(403, 'Unauthorized action.');
      }
    }
  }
}
