<?php

namespace LaravelEnso\Core\Http\Middleware;

use Closure;

class VerifyActiveState
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
        if (!$request->user()->is_active) {
            \Auth::logout();
            return redirect('/login')->withErrors(['is_active' => __('validation.disabled')]);
        }

        return $next($request);
    }
}
