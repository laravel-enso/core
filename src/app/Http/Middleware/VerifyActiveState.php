<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled() || $request->user()->owner()->isDisabled()) {
            auth()->logout();

            throw new AuthenticationException(__(config('enso.labels.disabledAccount')));
        }

        return $next($request);
    }
}
