<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MarketplaceAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('marketplace.login'));
        }

        return $next($request);
    }
}
