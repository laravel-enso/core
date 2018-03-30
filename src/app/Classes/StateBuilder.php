<?php

namespace LaravelEnso\Core\app\Classes;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Enums\Themes;
use Tightenco\Ziggy\BladeRouteGenerator;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\MenuManager\app\Classes\MenuBuilder;
use LaravelEnso\PermissionManager\app\Models\Permission;

class StateBuilder
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function get()
    {
        return $this->state();
    }

    private function state()
    {
        $languages = Language::active()
            ->pluck('flag', 'name');

        return [
            'user' => $this->user->append(['avatarId', 'preferences'])
                ->load(['role.permissions']),
            'menus' => $this->menus(),
            'i18n' => $this->i18n($languages),
            'languages' => $languages,
            'themes' => Themes::all(),
            'implicitMenu' => $this->user->role->menu,
            'impersonating' => session()->has('impersonating'),
            'meta' => $this->meta(),
            'routes' => $this->routes(),
        ];
    }

    private function menus()
    {
        $menus = $this->user->role->menus()->orderBy('order')
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
        $forbidden = Permission::whereNotIn('id', $this->user->role->permissionList)
            ->pluck('name');
        \Log::info(app(BladeRouteGenerator::class)->getRoutePayload()->keys());

        return app(BladeRouteGenerator::class)
            ->getRoutePayload()
            ->filter(function ($value, $key) use ($forbidden) {
                return !$forbidden->contains($key);
            });
    }
}
