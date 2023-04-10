<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        $currenturl = url()->full();
        $exp_arr = explode("/",$currenturl);
        
        if(in_array("superadmin",$exp_arr))
        {
            return '/superadmin/login';
        }
        else if(in_array("admin",$exp_arr))
        {
            return '/admin/login';
        }
        else if(in_array("surveyor",$exp_arr))
        {
            return '/surveyor/login';
        }
        else if(in_array("draftsman",$exp_arr))
        {
            return '/draftsman/login';
        }
        else if(in_array("accountant",$exp_arr))
        {
            return '/accountant/login';
        }
        else if(in_array("customer",$exp_arr))
        {
            return '/customer/login';
        }
        

        if (! $request->expectsJson()) {
            // return redirect('/login');
        }
    }
}
