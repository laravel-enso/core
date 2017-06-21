<?php

namespace LaravelEnso\Core\app\Classes\StructureManager;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;

class StructureDestroyer
{
    private $group;
    private $permissions;
    private $menu;

    public function destroy()
    {
        \DB::transaction(function () {
            if ($this->permissions && $this->permissions->count()) {
                $this->permissions->each->delete();
            }

            if ($this->group) {
                if (!$this->group->permissions->count()) {
                    $this->group->delete();
                }
            }

            if ($this->menu) {
                $this->menu->delete();
            }
        });
    }

    public function setPermissionGroup($group)
    {
        $this->group = PermissionGroup::whereName($group['name'])->first();
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
