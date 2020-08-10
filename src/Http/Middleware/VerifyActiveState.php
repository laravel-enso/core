<?php

namespace LaravelEnso\Core\Http\Middleware;

use Closure;
use LaravelEnso\Core\Exceptions\Authentication;
use LaravelEnso\Core\Traits\Logout;

class VerifyActiveState
{
    use Logout;

    public function handle($request, Closure $next)
    {
        if ($request->user()->isInactive()) {
            $this->logout($request);

            throw Authentication::disabledAccount();
        }

        return $next($request);
    }
}
