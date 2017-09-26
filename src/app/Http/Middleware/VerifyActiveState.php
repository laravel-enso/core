<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled()) {
            auth()->logout();
            throw new \EnsoException(__(config('enso.labels.disabledAccount')), 401);
        }

        return $next($request);
    }
}
