<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth()->user()->is_adm == 1) {
            return $next($request);
        }

        throw new \Exception("Invalid user role, you can not access this route.", 422);
    }
}
