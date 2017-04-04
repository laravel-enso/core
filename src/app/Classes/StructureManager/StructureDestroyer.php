<?php

namespace LaravelEnso\Core\app\Classes\StructureManager;

use LaravelEnso\Core\app\Models\Menu;
use LaravelEnso\Core\app\Models\PermissionsGroup;

class StructureDestroyer
{
    private $permissionsGroup;
    private $menu;

    public function destroy()
    {
        \DB::transaction(function () {
            if ($this->permissionsGroup) {
                $this->permissionsGroup->permissions->each->delete();
                $this->permissionsGroup->delete();
            }

            if ($this->menu) {
                $this->menu->roles->each(function($role) {
                    $role->menu_id = null;
                    $role->save();
                });

                $this->menu->delete();
            }
        });
    }

    public function setPermissionsGroup($permissionsGroup)
    {
        $this->permissionsGroup = PermissionsGroup::whereName($permissionsGroup['name'])->first();
    }

    public function setMenu($menu)
    {
        $this->menu = Menu::whereName($menu['name'])->first();
    }
}
