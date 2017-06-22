<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled()) {
            \Auth::logout();

            if ($request->ajax()) {
                throw new \EnsoException(__('validation.disabled'), 'warning', [], 403);
            }

            return redirect('/login')->withErrors(['is_active' => __('validation.disabled')]);
        }

        return $next($request);
    }
}
