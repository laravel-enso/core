<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled() || $request->user()->owner->isDisabled()) {
            auth()->logout();

            throw new AuthenticationException(__(
                'Your account has been disabled. Please contact the administrator.'
            ));
        }

        return $next($request);
    }
}
