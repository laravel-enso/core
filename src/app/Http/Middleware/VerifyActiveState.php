<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isInactive()) {
            Auth::logout();

            throw new AuthenticationException(__(
                'Your account has been disabled. Please contact the administrator.'
            ));
        }

        return $next($request);
    }
}
