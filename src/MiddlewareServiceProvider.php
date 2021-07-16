<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\ActionLogger\Http\Middleware\ActionLogger;
use LaravelEnso\Core\Http\Middleware\EnsureFrontendRequestsAreStateful as Stateful;
use LaravelEnso\Core\Http\Middleware\VerifyActiveState;
use LaravelEnso\Core\Http\Middleware\XssSanitizer;
use LaravelEnso\Impersonate\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\Http\Middleware\SetLanguage;
use LaravelEnso\Permissions\Http\Middleware\VerifyRouteAccess;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']
            ->aliasMiddleware('verify-active-state', VerifyActiveState::class);

        $this->app['router']
            ->aliasMiddleware('xss-sanitizer', XssSanitizer::class);

        $this->app['router']
            ->aliasMiddleware('ensure-frontent-requests-are-stateful', Stateful::class);

        $this->app['router']->middlewareGroup('core', [
            VerifyActiveState::class,
            ActionLogger::class,
            Impersonate::class,
            VerifyRouteAccess::class,
            SetLanguage::class,
        ]);
    }
}
