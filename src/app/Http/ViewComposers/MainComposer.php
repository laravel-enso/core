<?php

namespace LaravelEnso\Core\app\Http\ViewComposers;

use Illuminate\View\View;
use LaravelEnso\Core\app\Enums\Themes;
use LaravelEnso\Helpers\Classes\Object;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\MenuManager\app\Classes\MenuGenerator;
use LaravelEnso\MenuManager\app\Models\Menu;

class MainComposer
{
    private $store;
    private $menu;

    public function __construct()
    {
        $this->store = new Object();
        $this->setStore();
        $this->setMenu();
    }

    public function compose(View $view)
    {
        $view->with([
            'menu'  => $this->menu,
            'store' => $this->store,
        ]);
    }

    private function setMenu()
    {
        $menus = Menu::whereHas('roles', function ($query) {
            $query->whereRoleId($this->store->user->role_id);
        })->orderBy('order')->get();

        $this->menu = new MenuGenerator($menus);
    }

    private function setStore()
    {
        $this->store->user = request()->user();
        $this->store->user->append(['avatarId', 'preferences']);
        $this->store->languages = Language::all();
        $this->store->themes = (new Themes())->getData();
        $this->store->pusherKey = config('broadcasting.connections.pusher.key');
        $this->store->labels = $this->getLabels();
        $this->store->route = request()->route()->getName();
    }

    private function getLabels()
    {
        return collect(config('labels'))->map(function ($label) {
            return __($label);
        });
    }
}
