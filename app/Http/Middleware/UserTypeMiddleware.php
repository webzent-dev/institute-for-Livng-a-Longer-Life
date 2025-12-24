<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
     
    public function handle($request, Closure $next, ...$types)
    {
       $user = $request->user();

        if (! $user || ! in_array($user->type, $types)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
