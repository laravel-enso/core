<?php

namespace LaravelEnso\Core\App\Http\Middleware;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful as Middleware;

class EnsureFrontendRequestsAreStateful extends Middleware
{
    public static function fromFrontend($request)
    {
        return ! $request->header('webview')
            && ! $request->cookie('webview')
            && parent::fromFrontend($request);
    }
}
