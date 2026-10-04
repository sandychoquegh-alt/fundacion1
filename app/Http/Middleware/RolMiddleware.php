<?php

namespace App\Http\Middleware;

use Closure;

class RolMiddleware
{
    public function handle($request, Closure $next, $rol)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->rol_id != $rol) {
            abort(403);
        }

        return $next($request);
    }
}