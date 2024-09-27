<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        // Ensure auth user exists and compare user_type
        if (auth()->check() && auth()->user()->user_type != $type) {
            return redirect('/'); // Redirect if not authorized
        }

        return $next($request);
    }
}
