<?php

namespace LaravelEnso\Core\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\App\Exceptions\Authentication;

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
