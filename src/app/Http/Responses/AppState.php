<?php

namespace LaravelEnso\Core\app\Http\Responses;

use LaravelEnso\Core\app\Enums\Themes;
use LaravelEnso\People\app\Enums\Genders;
use LaravelEnso\Core\app\Classes\Inspiring;
use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\Helpers\app\Classes\JsonParser;
use LaravelEnso\Core\app\Contracts\StateBuilder;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\MenuManager\app\Classes\MenuBuilder;

class AppState implements Responsable
{
    public function toResponse($request)
    {
        return $this->state();
    }

    private function state()
    {
        $response = $this->response();

        unset(auth()->user()->role);

        return $response;
    }

    private function response()
    {
        $languages = Language::active()
            ->pluck('flag', 'name');

        $localState = config('enso.config.stateBuilder');

        return [
            'user' => auth()->user()->load(['person', 'avatar']),
            'preferences' => auth()->user()->preferences(),
            'i18n' => $this->i18n($languages),
            'languages' => $languages,
            'themes' => Themes::all(),
            'routes' => $this->routes(),
            'implicitMenu' => auth()->user()->role->menu,
            'menus' => $this->menus(),
            'impersonating' => session()->has('impersonating'),
            'meta' => $this->meta(),
            'enums' => $this->enums(),
            'local' => class_exists($localState)
                ? $this->localState(new $localState())
                : null,
        ];
    }

    private function menus()
    {
        $menus = auth()->user()->role
            ->menus()
            ->orderBy('order_index')
            ->get(['id', 'icon', 'link', 'name', 'parent_id', 'has_children']);

        return (new MenuBuilder($menus))->get();
    }

    private function i18n($languages)
    {
        return $languages->keys()
            ->reduce(function ($i18n, $lang) {
                if ($lang === 'en') {
                    return $i18n;
                }

                $i18n[$lang] = (new JsonParser(
                    resource_path('lang'.DIRECTORY_SEPARATOR.$lang.'.json')
                ))->object();

                return $i18n;
            }, []);
    }

    private function meta()
    {
        return [
            'appName' => config('app.name'),
            'appUrl' => url('/').'/',
            'version' => config('enso.config.version'),
            'quote' => Inspiring::quote(),
            'env' => app()->environment(),
            'dateFormat' => config('enso.config.jsDateFormat'),
            'extendedDocumentTitle' => config('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'pusher' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
            'ravenKey' => config('enso.config.ravenKey'),
        ];
    }

    private function enums()
    {
        return [
            'genders' => Genders::all(),
        ];
    }

    private function routes()
    {
        return auth()->user()->role
            ->permissions()
            ->pluck('name')
            ->reduce(function ($collection, $permission) {
                $route = \Route::getRoutes()->getByName($permission);

                $collection[$permission] = $route
                    ? collect($route)->only(['uri', 'methods'])
                        ->put('domain', $route->domain())
                    : null;

                return $collection;
            }, []);
    }

    private function localState(StateBuilder $state)
    {
        return $state->build();
    }
}
