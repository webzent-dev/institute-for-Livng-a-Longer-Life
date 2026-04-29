<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/auth'); // Not logged in
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized'); // Or redirect anywhere
        }

        return $next($request);
    }
}
