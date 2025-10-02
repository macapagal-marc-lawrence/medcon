<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsDrugstore
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->usertype === 'drugstore') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
