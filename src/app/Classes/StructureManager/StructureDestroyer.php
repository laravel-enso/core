<?php

namespace LaravelEnso\Core\app\Classes\StructureManager;

use LaravelEnso\Core\app\Models\Menu;
use LaravelEnso\Core\app\Models\Permission;
use LaravelEnso\Core\app\Models\PermissionsGroup;

class StructureDestroyer
{
    private $permissionsGroup;
    private $permissions;
    private $menu;

    public function destroy()
    {
        \DB::transaction(function () {
            if ($this->permissions && $this->permissions->count()) {
                $this->permissions->each->delete();
            }

            if ($this->permissionsGroup) {
                if (!$this->permissionsGroup->permissions->count()) {
                    $this->permissionsGroup->delete();
                }
            }

            if ($this->menu) {
                $this->menu->delete();
            }
        });
    }

    public function setPermissionsGroup($permissionsGroup)
    {
        $this->permissionsGroup = PermissionsGroup::whereName($permissionsGroup['name'])->first();
    }

    public function setPermissions($permissions)
    {
        $this->permissions = collect();

        foreach ($permissions as $permission) {
            $this->permissions->push(Permission::whereName($permission['name'])->first());
        }
    }

    public function setMenu($menu)
    {
        $this->menu = Menu::whereName($menu['name'])->first();
    }
}
