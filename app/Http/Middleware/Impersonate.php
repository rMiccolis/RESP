<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

/**
 * Il middleware Impersonate consente di impersonificare un utente, 
 * mentre si è già loggati nel sistema.
 */
class Impersonate
{
    public function handle($request, Closure $next)
    {
        if($request->session()->has('impersonate'))
        {
            Auth::onceUsingId($request->session()->get('impersonate'));
        }
        return $next($request);
    }
}