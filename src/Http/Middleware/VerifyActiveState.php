<?php

namespace LaravelEnso\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Exceptions\Authentication;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isInactive()) {
            Auth::logout();

            throw Authentication::disabledAccount();
        }

        return $next($request);
    }
}
