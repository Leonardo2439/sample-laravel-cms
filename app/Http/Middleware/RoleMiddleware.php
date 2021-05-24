<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // dd($request->user()->userHasRole($role));

        if (!$request->user()->userHasRole($role)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
