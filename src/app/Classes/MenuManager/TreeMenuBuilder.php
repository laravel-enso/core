<?php

namespace LaravelEnso\Core\app\Classes\MenuManager;

class TreeMenuBuilder
{
    private $treeMenu = [];
    private $menus;

    public function __construct($menus)
    {
        $this->menus = $menus;
        $this->treeMenu = $this->buildTreeMenu();
    }

    private function buildTreeMenu($parentId = null)
    {
        $menus = [];

        foreach ($this->menus as $menu) {
            if ($menu->parent_id !== $parentId) {
                continue;
            }

            $menus[] = $this->appendMenu($menu);
        }

        return $menus;
    }

    private function appendMenu($menu)
    {
        $menu->children = $menu->has_children ? $this->buildTreeMenu($menu->id) : [];

        $menu['unique_id'] = $menu['id'];
        unset($menu['id']);

        return $menu;
    }

    public function getData()
    {
        return json_encode($this->treeMenu);
    }
}
