<?php

namespace LaravelEnso\Core\App\Http\Middleware;

class AuthorizationCookie
{
    public function handle($request, $next)
    {
        if (! $request->bearerToken() && $request->cookie('Authorization')) {
            $request->headers->set(
                'Authorization',
                "Bearer {$request->cookie('Authorization')}"
            );
        }

        return $next($request);
    }
}
