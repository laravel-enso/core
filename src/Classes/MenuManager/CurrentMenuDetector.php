<?php

namespace LaravelEnso\Core\Classes\MenuManager;

use LaravelEnso\Helpers\Classes\AbstractObject;

class CurrentMenuDetector extends AbstractObject
{
    private $menus;
    private $path;
    public $menu;

    public function __construct($menus)
    {
        $this->menus = $menus;
        $this->path = request()->path();
        $this->menu = $this->get();
    }

    private function get()
    {
        if (is_null($this->path)) {
            return;
        }

        $currentMenu = $this->getCurrentMenu();

        if ($currentMenu !== false) {
            return $currentMenu;
        }

        $this->trimPathTermination();

        return $this->get();
    }

    private function getCurrentMenu()
    {
        $index = $this->menus->search(function ($menu) {
            return $menu->link == $this->path;
        });

        return $index !== false ? $this->menus[$index] : false;
    }

    private function trimPathTermination()
    {
        $separatorIndex = strrpos($this->path, '/');

        $this->path = $separatorIndex !== false ? substr($this->path, 0, $separatorIndex) : null;
    }

    public function getData()
    {
        return $this->menu;
    }
}
