<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  Request  $request
     * @param  mixed  $userType
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if (auth()->check() && auth()->user()->user_type == $userType) {
            return $next($request);
        }

        abort(401);
    }
}


