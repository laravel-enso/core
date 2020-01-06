<?php

namespace LaravelEnso\Core\App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use LaravelEnso\Core\App\Enums\Themes;
use LaravelEnso\Core\App\Services\Inspiring;
use LaravelEnso\Core\App\Services\LocalState;
use LaravelEnso\Enums\App\Facades\Enums;
use LaravelEnso\Enums\App\Services\Enum;
use LaravelEnso\Helpers\App\Classes\JsonParser;
use LaravelEnso\Localisation\App\Models\Language;
use LaravelEnso\Menus\App\Services\TreeBuilder;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Enums\Roles;
use LaravelEnso\Roles\App\Models\Role;

class AppState implements Responsable
{
    private Role $role;
    private Collection $languages;

    public function toResponse($request): array
    {
        $this->prepare();

        return $this->response();
    }

    private function response(): array
    {
        return [
            'user' => Auth::user()->load(['person', 'avatar']),
            'preferences' => Auth::user()->preferences(),
            'i18n' => $this->i18n(),
            'languages' => $this->languages->pluck('flag', 'name'),
            'rtl' => $this->rtl(),
            'themes' => Themes::all(),
            'routes' => $this->routes(),
            'implicitRoute' => $this->role->menu->permission->name,
            'menus' => (new TreeBuilder())->handle(),
            'impersonating' => Session::has('impersonating'),
            'websockets' => [
                'pusher' => [
                    'key' => config('broadcasting.connections.pusher.key'),
                    'options' => config('broadcasting.connections.pusher.options'),
                ],
                'channels' => [
                    'privateChannel' => $this->privateChannel(),
                    'ioChannel' => $this->ioChannel(),
                    'appUpdates' => 'app-updates',
                ],
            ],
            'meta' => $this->meta(),
            'enums' => Enums::all(),
            'local' => App::make(LocalState::class)->build(),
        ];
    }

    private function i18n(): Collection
    {
        return $this->languages
            ->reject(fn ($language) => $language->name === 'en')
            ->mapWithKeys(fn ($language) => [
                $language->name => $this->lang($language),
            ]);
    }

    private function lang(Language $language)
    {
        return (new JsonParser(
            resource_path('lang'.DIRECTORY_SEPARATOR."{$language->name}.json")
        ))->object();
    }

    private function rtl(): Collection
    {
        return $this->languages
            ->filter(fn ($lang) => $lang->is_rtl)->pluck('name');
    }

    private function meta(): array
    {
        return [
            'appName' => config('app.name'),
            'appUrl' => url('/').'/',
            'version' => config('enso.config.version'),
            'quote' => Inspiring::quote(),
            'env' => App::environment(),
            'dateFormat' => config('enso.config.dateFormat'),
            'dateTimeFormat' => config('enso.config.dateFormat').' H:i:s',
            'extendedDocumentTitle' => config('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'ravenKey' => config('enso.config.ravenKey'),
        ];
    }

    private function routes(): Collection
    {
        return $this->role->permissions
            ->mapWithKeys(fn ($permission) => [
                $permission->name => $this->route($permission),
            ]);
    }

    private function route(Permission $permission): ?array
    {
        $route = Route::getRoutes()->getByName($permission->name);

        return $route
            ? (new Collection($route))->only(['uri', 'methods'])
                ->put('domain', $route->domain())
                ->toArray()
            : null;
    }

    private function privateChannel(): string
    {
        return (new Collection(
            explode('\\', config('auth.providers.users.model'))
        ))->push(Auth::user()->id)->implode('.');
    }

    private function ioChannel(): string
    {
        $roles = App::make(Roles::class);

        return in_array(Auth::user()->role_id, [$roles::Admin, $roles::Supervisor])
            ? 'operations'
            : 'operations'.Auth::user()->id;
    }

    private function prepare(): void
    {
        $this->role = Auth::user()->role()
            ->with('menu.permission', 'permissions')->first();

        $this->languages = Language::active()
            ->get(['name', 'flag', 'is_rtl']);

        Enum::localisation(false);
    }
}
