<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            /** @var App\Models\user */
            $user = Auth::user();
            if($user::hashRole(['super-admin','admin'])){
                
                return $next($request);
            }

            abort(403, "User dose not have correct ROLE");
        }
        
        abort(401);
    }
}
