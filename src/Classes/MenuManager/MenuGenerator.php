<?php

namespace LaravelEnso\Core\Classes\MenuManager;

use LaravelEnso\Core\Classes\MenuManager\CurrentMenuDetector;

class MenuGenerator
{
    private $menus;
    private $activeMenusIds;
    private $currentMenuDetector;
    public $html;

    public function __construct($menus)
    {
        $this->menus          = $menus;
        $menuDetector         = new CurrentMenuDetector($menus);
        $this->currentMenu    = $menuDetector->getData();
        $this->activeMenusIds = $this->getActiveMenusIds();
        $this->generateMenu();
    }

    private function getActiveMenusIds()
    {
        $ids         = collect();
        $currentMenu = $this->currentMenu;

        while ($currentMenu) {
            $ids->push($currentMenu->id);
            $currentMenu = $currentMenu->parent;
        }

        return $ids;
    }

    private function generateMenu()
    {
        $this->html = '<aside class="main-sidebar"><section class="sidebar"><ul class="sidebar-menu"><li class="header">' . __("Main Menu") . '</li>';

        $this->buildCurrentLevelMenu();

        $this->html .= '</ul></section></aside>';
    }

    private function buildCurrentLevelMenu($parentId = null)
    {
        foreach ($this->menus as $menu) {
            $class = $this->isActive($menu) ? "active" : "";

            if ($menu->parent_id !== $parentId) {
                continue;
            }

            if ($menu->has_children) {
                $this->addMenuWithChildren($menu, $class);
            } else {
                $this->addMenu($menu, $class);
            }
        }
    }

    private function isActive($menu)
    {
        return $this->activeMenusIds->contains($menu->id);
    }

    private function addMenuWithChildren($menu, $class)
    {
        $this->html .= '<li class="' . $class . '">';
        $icon = '<i class="fa fa-angle-left pull-right"></i>';
        $this->addMenuLabel($menu, $icon);
        $this->html .= '<ul class="treeview-menu">';
        $this->buildCurrentLevelMenu($menu->id);
        $this->html .= '</ul></li>';
    }

    private function addMenu($menu, $class)
    {
        $this->html .= '<li class ="' . $class . '">';
        $this->addMenuLabel($menu);
        $this->html .= '</li>';
    }

    private function addMenuLabel($menu, $angle = '')
    {
        $link = $menu->has_children ? '#' : ('/' . $menu->link);
        $this->html .= "<a href = '" . $link . "'><i class = '" . $menu->icon . "'></i><span>" . __($menu->name) . "</span>$angle</a>";
    }
}
