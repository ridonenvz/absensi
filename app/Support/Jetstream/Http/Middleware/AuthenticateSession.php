<?php

namespace Laravel\Jetstream\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateSession
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
