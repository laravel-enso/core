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
        $this->store = new Object();
        $this->store->user = request()->user();
        $this->store->languages = Language::all();
        $this->store->themes = (new Themes())->getData();
        $this->store->pusherKey = config('broadcasting.connections.pusher.key');
        $this->store->labels = $this->getLabels();
        $this->store->route = request()->route()->getName();
    }

    private function getLabels()
    {
        return collect([
            'generalSettings' => __('General Settings'),
            'reset'           => __('Reset'),
            'language'        => __('Language'),
            'startTutorial'   => __('Start Tutorial'),
            'stateSave'       => __('Tables State Save'),
            'fixed'           => __('Fixed layout'),
            'collapse'        => __('Collapse'),
            'theme'           => __('Theme'),
            'profile'         => __('Profile'),
            'logout'          => __('Logout'),
        ]);
    }
}
