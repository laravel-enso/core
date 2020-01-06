<?php

namespace LaravelEnso\Core\App\Http\Middleware;

use App\Exceptions\Authentication;
use Closure;
use Illuminate\Support\Facades\Auth;

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
