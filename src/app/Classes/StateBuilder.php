<?php

namespace LaravelEnso\Core\app\Classes;

use LaravelEnso\Core\app\Enums\Themes;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\MenuManager\app\Classes\MenuBuilder;

class StateBuilder
{
    private $user;
    private $state;
    private $permissions;

    public function __invoke(User $user)
    {
        $this->user = $user->append(['avatarId', 'preferences'])
            ->load(['role.permissions']);

        $this->setState();

        return $this->state;
    }

    private function setState()
    {
        $languages = Language::get(['name', 'flag']);
        $menus = $this->getMenus();

        $this->state = [
            'menus'         => $menus,
            'i18n'          => $this->getI18N($languages),
            'languages'     => $languages->pluck('flag', 'name'),
            'locale'        => $this->user->preferences->global->lang,
            'themes'        => collect((new Themes())->all()),
            'theme'         => 'clean',
            'csrfToken'     => csrf_token(),
            'pusherToken'   => config('broadcasting.connections.pusher.key'),
            'implicitMenu'  => $this->user->role->menu,
            'user'          => $this->user,
            'impersonating' => session()->has('impersonating'),
            'dateFormat'    => config('enso.config.jsDateFormat'),
            'meta'          => $this->getMeta(),
        ];
    }

    private function getMenus()
    {
        $menus = $this->user->role->menus()->orderBy('order')
            ->get(['id', 'icon', 'link', 'name', 'parent_id', 'has_children']);

        return (new MenuBuilder($menus))->get();
    }

    private function getI18N($languages)
    {
        return $languages->reduce(function ($i18n, $lang) {
            if ($lang->name === 'en') {
                return $i18n;
            }

            $json = json_decode(\File::get(
                resource_path('lang'.DIRECTORY_SEPARATOR.$lang->name.'.json')
            ));

            $i18n[$lang->name] = $json;

            return $i18n;
        }, []);
    }

    private function getMeta()
    {
        return [
            'appName' => config('app.name'),
            'version' => config('enso.config.version'),
        ];
    }
}
