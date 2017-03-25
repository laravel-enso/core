<?php

namespace LaravelEnso\Core\App\Classes\StructureManager;

use LaravelEnso\Core\App\Models\Menu;
use LaravelEnso\Core\App\Models\Permission;
use LaravelEnso\Core\App\Models\PermissionsGroup;
use LaravelEnso\Core\App\Models\Role;

class StructureCreator
{
    private $defaultRole;
    private $permissionsGroup;
    private $permissions;
    private $parentMenu;
    private $menu;
    private $role;

    public function __construct()
    {
        $this->defaultRole = config('laravel-enso.defaultRole');
        $this->permissionsGroup = null;
        $this->permissions = collect();
        $this->menu = null;
        $this->parentMenu = null;
    }

    public function create()
    {
        $this->checkIfRoleGiven();

        \DB::transaction(function () {
            $this->createPermissions();
            $this->createMenu();
        });
    }

    private function checkIfRoleGiven()
    {
        if (!$this->role) {
            $this->setRole($this->defaultRole);
        }
    }

    private function createPermissions()
    {
        if (!$this->permissionsGroup) {
            return;
        }

        $this->permissionsGroup->save();

        foreach ($this->permissions as $permission) {
            $permission->permissions_group_id = $this->permissionsGroup->id;
            $permission->save();
            $permission->roles()->attach($this->role);
        }
    }

    private function createMenu()
    {
        if (!$this->menu) {
            return;
        }

        $this->menu->save();

        $this->menu->roles()->attach($this->role);
    }

    public function setPermissionsGroup($permissionsGroup)
    {
        $this->permissionsGroup = new PermissionsGroup($permissionsGroup);
    }

    public function setPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->permissions->push(new Permission($permission));
        }
    }

    public function setParentMenu($menu)
    {
        $this->parentMenu = Menu::whereName($menu)->first();
    }

    public function setMenu($menu)
    {
        $this->menu = new Menu($menu);

        if ($this->parentMenu) {
            $this->menu->parent_id = $this->parentMenu->id;
        }
    }

    public function setRole($role)
    {
        $this->role = Role::whereName($role)->first();
    }
}
