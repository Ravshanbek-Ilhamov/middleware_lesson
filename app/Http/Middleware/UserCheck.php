<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRoles = Auth::user()->roles->whereIn('name', $roles)->where('is_active', true);

        if ($userRoles->isNotEmpty()) {
            return $next($request);
        }
        abort(403, 'Unauthorized access');
    }
}
