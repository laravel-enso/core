<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Roles\app\Models\Role;

class StructureUpgrade extends DatabaseUpgrade
{
    protected $permissions = [];

    protected function isMigrated()
    {
        return collect($this->permissions)->isEmpty()
            || Permission::whereName($this->permissions[0]['name'])->first() !== null;
    }

    protected function migrateData()
    {
        collect($this->permissions)->each(function ($permission) {
            $newPermission = Permission::create($permission);
            $newPermission->roles()->sync($this->determineRoles($newPermission));
        });
    }

    protected function determineRoles(Permission $permission)
    {
        if ($permission->is_default) {
            return Role::pluck('id');
        }

        return Role::whereName(config('enso.config.defaultRole'))
            ->first()
            ->id;
    }
}
