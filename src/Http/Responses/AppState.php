<?php

namespace LaravelEnso\Core\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use LaravelEnso\Core\Enums\Themes;
use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\Core\Http\Resources\User;
use LaravelEnso\Core\Services\Inspiring;
use LaravelEnso\Core\Services\LocalState;
use LaravelEnso\Enums\Facades\Enums;
use LaravelEnso\Enums\Services\Enum;
use LaravelEnso\Helpers\Services\JsonReader;
use LaravelEnso\Localisation\Models\Language;
use LaravelEnso\Menus\Http\Resources\Menu;
use LaravelEnso\Menus\Services\TreeBuilder;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;

class AppState implements Responsable
{
    protected Role $role;
    protected Collection $languages;

    public function toResponse($request): array
    {
        $this->prepare();

        return $this->response();
    }

    protected function response(): array
    {
        return [
            'user' => new User(Auth::user()->load(['person', 'avatar', 'role', 'group'])),
            'preferences' => Auth::user()->preferences(),
            'i18n' => $this->i18n(),
            'languages' => $this->languages->pluck('flag', 'name'),
            'rtl' => $this->rtl(),
            'themes' => Themes::all(),
            'routes' => $this->routes(),
            'implicitRoute' => $this->role->menu->permission->name,
            'menus' => Menu::collection(App::make(TreeBuilder::class)->handle()),
            'impersonating' => Session::has('impersonating'),
            'websockets' => [
                'pusher' => [
                    'key' => Config::get('broadcasting.connections.pusher.key'),
                    'options' => Config::get('broadcasting.connections.pusher.options'),
                ],
                'channels' => Websockets::all(),
            ],
            'meta' => $this->meta(),
            'enums' => Enums::all(),
            'local' => App::make(LocalState::class)->build(),
        ];
    }

    protected function i18n(): Collection
    {
        return $this->languages
            ->reject(fn ($language) => $language->name === 'en')
            ->mapWithKeys(fn ($language) => [
                $language->name => $this->lang($language),
            ]);
    }

    protected function lang(Language $language)
    {
        return (new JsonReader(
            resource_path('lang'.DIRECTORY_SEPARATOR."{$language->name}.json")
        ))->object();
    }

    protected function rtl(): Collection
    {
        return $this->languages
            ->filter(fn ($lang) => $lang->is_rtl)->pluck('name');
    }

    protected function meta(): array
    {
        return [
            'appName' => Config::get('app.name'),
            'appUrl' => url('/').'/',
            'version' => Config::get('enso.config.version'),
            'quote' => Inspiring::quote(),
            'env' => App::environment(),
            'dateFormat' => Config::get('enso.config.dateFormat'),
            'dateTimeFormat' => Config::get('enso.config.dateFormat').' H:i:s',
            'extendedDocumentTitle' => Config::get('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'sentryDsn' => Config::get('sentry.dsn'),
        ];
    }

    protected function routes(): Collection
    {
        return $this->role->permissions
            ->mapWithKeys(fn ($permission) => [
                $permission->name => $this->route($permission),
            ]);
    }

    protected function route(Permission $permission): ?array
    {
        $route = Route::getRoutes()->getByName($permission->name);

        return $route
            ? (new Collection($route))->only(['uri', 'methods'])
            ->put('domain', $route->domain())
            ->toArray()
            : null;
    }

    protected function prepare(): void
    {
        $this->role = Auth::user()->role()
            ->with('menu.permission', 'permissions')->first();

        $this->languages = Language::active()
            ->get(['name', 'flag', 'is_rtl']);

        Enum::localisation(false);
    }
}
