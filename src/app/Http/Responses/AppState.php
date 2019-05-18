<?php

namespace LaravelEnso\Core\app\Http\Responses;

use Illuminate\Support\Facades\App;
use LaravelEnso\Core\app\Enums\Themes;
use LaravelEnso\IO\app\Enums\IOStatuses;
use LaravelEnso\Helpers\app\Classes\Enum;
use LaravelEnso\People\app\Enums\Genders;
use LaravelEnso\Core\app\Services\Inspiring;
use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\Calendar\app\Enums\Calendars;
use LaravelEnso\Helpers\app\Classes\JsonParser;
use LaravelEnso\Menus\app\Services\TreeBuilder;
use LaravelEnso\Core\app\Contracts\StateBuilder;
use LaravelEnso\Localisation\app\Models\Language;

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
        Enum::localisation(false);

        $languages = Language::active()
            ->get(['name', 'flag', 'is_rtl']);

        $langs = $languages->pluck('flag', 'name');
        $localState = config('enso.config.stateBuilder');

        return [
            'user' => auth()->user()->load(['person', 'avatar']),
            'preferences' => auth()->user()->preferences(),
            'i18n' => $this->i18n($langs),
            'languages' => $langs,
            'rtl' => $this->rtl($languages),
            'themes' => Themes::all(),
            'routes' => $this->routes(),
            'implicitRoute' => auth()->user()->role->menu->permission->name,
            'menus' => (new TreeBuilder())->handle(),
            'impersonating' => session()->has('impersonating'),
            'websockets' => [
                'pusher' => [
                    'key' => config('broadcasting.connections.pusher.key'),
                    'options' => config('broadcasting.connections.pusher.options'),
                ],
                'privateChannel' => 'App.User.'.auth()->user()->id,
                'ioChannel' => $this->ioChannel(),
            ],
            'meta' => $this->meta(),
            'enums' => $this->enums(),
            'local' => class_exists($localState)
                ? $this->localState(new $localState())
                : null,
        ];
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

    private function rtl($languages)
    {
        return $languages->filter(function ($lang) {
            return $lang->is_rtl;
        })->pluck('name');
    }

    private function meta()
    {
        return [
            'appName' => config('app.name'),
            'appUrl' => url('/').'/',
            'version' => config('enso.config.version'),
            'quote' => Inspiring::quote(),
            'env' => app()->environment(),
            'dateFormat' => config('enso.config.dateFormat'),
            'extendedDocumentTitle' => config('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'ravenKey' => config('enso.config.ravenKey'),
        ];
    }

    private function enums()
    {
        return [
            'genders' => Genders::all(),
            'calendars' => Calendars::all(),
            'ioStatuses' => IOStatuses::all(),
            'roles' => App::make('roles'),
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

    private function ioChannel()
    {
        $roles = App::make('roles');

        return collect([$roles::Admin, $roles::Supervisor])
            ->contains(auth()->user()->role_id)
            ? 'operations'
            : 'operations'.auth()->user()->id;
    }

    private function localState(StateBuilder $state)
    {
        return $state->build();
    }
}
