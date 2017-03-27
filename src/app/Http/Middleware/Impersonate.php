<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;

class Impersonate
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('impersonate')) {
            \Auth::onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}
