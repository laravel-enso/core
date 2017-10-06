<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled()) {
            auth()->logout();

            if ($request->ajax()) {
                throw new \EnsoException(__('validation.disabled'));
            }

            return redirect('/login')->withErrors(['is_active' => __('validation.disabled')]);
        }

        return $next($request);
    }
}
