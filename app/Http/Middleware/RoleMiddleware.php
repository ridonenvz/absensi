<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Izinkan akses hanya untuk role tertentu.
     * Contoh penggunaan: middleware('role:admin,pimpinan')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $role = Auth::user()->role ?? null;

        if (!in_array($role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
