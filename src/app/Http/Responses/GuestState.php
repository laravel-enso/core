<?php

namespace LaravelEnso\Core\app\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class GuestState implements Responsable
{
    public function toResponse($request)
    {
        return [
            'meta' => $this->meta(),
            'i18n' => $this->i18n(),
            'routes' => $this->routes(),
        ];
    }

    private function meta()
    {
        return [
            'appName' => config('app.name'),
            'appUrl' => url('/').'/',
            'extendedDocumentTitle' => config('enso.config.extendedDocumentTitle'),
        ];
    }

    private function i18n()
    {
        return [
            app()->getLocale() => [
                'Email' => __('Email'),
                'Password' => __('Password'),
                'Remember me' => __('Remember me'),
                'Forgot password' => __('Forgot password'),
                'Login' => __('Login'),
                'Send a reset password link' => __('Send a reset password link'),
                'Repeat Password' => __('Repeat Password'),
                'Success' => __('Success'),
                'Error' => __('Error'),
            ],
        ];
    }

    private function routes()
    {
        $authRoutes = collect(['login', 'password.email', 'password.reset']);

        return collect(\Route::getRoutes()->getRoutesByName())
            ->filter(function ($route, $name) use ($authRoutes) {
                return $authRoutes->contains($name);
            })->map(function ($route) {
                return collect($route)->only(['uri', 'methods'])
                    ->put('domain', $route->domain());
            });
    }
}
