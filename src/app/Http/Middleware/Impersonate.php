<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use LaravelEnso\Core\app\Http\Middleware\VerifyRouteAccess;

class Impersonate
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('impersonate')) {
            \Auth::onceUsingId($request->session()->get('impersonate'));

            return (new VerifyRouteAccess)->handle($request, $next);
        }

        return $next($request);
    }
}
