<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class UserGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        config(['auth.defaults.guard' => 'api']);
        return $next($request);
    }
}
