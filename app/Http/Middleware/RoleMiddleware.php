<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\UserRole;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (! auth()->check()) {
            abort(401);
        }

        $userRole = auth()->user()->role;

        foreach ($roles as $role) {
            if ($userRole === UserRole::from($role)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
