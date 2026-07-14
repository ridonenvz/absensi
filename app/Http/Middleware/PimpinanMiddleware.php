<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role !== 'pimpinan') {
            abort(403);
        }

        return $next($request);
    }
}