<?php

namespace LaravelEnso\Core\app\Http\Responses;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Enums\Themes;
use LaravelEnso\Core\app\Classes\Inspiring;
use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\MenuManager\app\Classes\MenuBuilder;
use LaravelEnso\PermissionManager\app\Models\Permission;

class AppState implements Responsable
{
    public function toResponse($request)
    {
        return $this->state();
    }

    private function state()
    {
        $languages = Language::active()
            ->pluck('flag', 'name');

        return [
            'user' => auth()->user()->append(['avatarId'])
                ->load(['role.permissions']),
            'preferences' => auth()->user()->preferences(),
            'menus' => $this->menus(),
            'i18n' => $this->i18n($languages),
            'languages' => $languages,
            'themes' => Themes::all(),
            'implicitMenu' => auth()->user()->role->menu,
            'impersonating' => session()->has('impersonating'),
            'meta' => $this->meta(),
            'routes' => $this->routes(),
        ];
    }

    private function menus()
    {
        $menus = auth()->user()->role->menus()->orderBy('order')
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

                $json = json_decode(\File::get(
                    resource_path('lang'.DIRECTORY_SEPARATOR.$lang.'.json')
                ));

                $i18n[$lang] = $json;

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
            'env' => config('app.env'),
            'dateFormat' => config('enso.config.jsDateFormat'),
            'extendedDocumentTitle' => config('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'pusher' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
            'ravenKey' => config('enso.config.ravenKey'),
        ];
    }

    private function routes()
    {
        $forbidden = Permission::whereNotIn('id', auth()->user()->role->permissionList)
            ->pluck('name');

        return collect(\Route::getRoutes()->getRoutesByName())
            ->reject(function ($value, $key) use ($forbidden) {
                return $forbidden->contains($key);
            })->map(function ($route) {
                return collect($route)->only(['uri', 'methods'])
                    ->put('domain', $route->domain());
            });
    }
}
