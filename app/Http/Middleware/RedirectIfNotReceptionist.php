<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectIfNotReceptionist
{
    public function handle(Request $request, Closure $next, $guard = 'receptionist')
    {
        if (!Auth::guard($guard)->check()) {
            return to_route('receptionist.login');
        }
        return $next($request);
    }
}
