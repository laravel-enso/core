<?php

namespace LaravelEnso\Core\app\Classes\StructureManager;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;
use LaravelEnso\RoleManager\app\Models\Role;

class StructureCreator
{
    private $defaultRole;
    private $group;
    private $permissions;
    private $parentMenu;
    private $menu;
    private $role;

    public function __construct()
    {
        $this->defaultRole = config('laravel-enso.defaultRole');
        $this->group = null;
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
        if (!$this->group) {
            return;
        }

        if (!$this->group->id) {
            $this->group->save();
        }

        foreach ($this->permissions as $permission) {
            $permission->permission_group_id = $this->group->id;
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

    public function setPermissionGroup($group)
    {
        $group = PermissionGroup::whereName($group['name'])->first();
        $this->group = $group ?: new PermissionGroup($group);
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
