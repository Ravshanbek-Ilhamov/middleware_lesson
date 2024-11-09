<?php

namespace App\Http\Middleware;

use App\Models\Permission;
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

        $routname = $request->route()->getName();
        // dd(Permission::where('key',$routname)->first());
        if(Auth::check()){
            if(Permission::where('key',$routname)->first()){
                $role = Auth::user()->roles->first();
                if ($role->permissions()->where('key',$routname)->exists()) {
                    return $next($request);
                }else{
                    abort(403);
                }
            
            }else{
                abort(404);
            }
        }else{
            return redirect('/');
        }
        // $userRoles = Auth::user()->roles->whereIn('name', $roles)->where('is_active', true);

        // if ($userRoles->isNotEmpty()) {
        //     return $next($request);
        // }
        // abort(403, 'Unauthorized access');
    }
}
