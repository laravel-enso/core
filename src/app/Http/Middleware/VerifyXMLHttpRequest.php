<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class VerifyXMLHttpRequest
{
    public function handle($request, Closure $next)
    {
        if (!$request->isXmlHttpRequest()) {
        	\Log::warning('Potential CSRF attempt');
        	\Log::warning($request->headers);

            throw new AuthorizationException();
        }

        return $next($request);
    }
}
