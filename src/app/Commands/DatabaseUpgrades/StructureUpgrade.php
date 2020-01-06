<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Collection;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Models\Role;

class StructureUpgrade extends DatabaseUpgrade
{
    protected $permissions = [];

    protected function isMigrated()
    {
        return empty($this->permissions)
            || Permission::whereName($this->permissions[0]['name'])->first() !== null;
    }

    protected function migrateData()
    {
        (new Collection($this->permissions))
            ->each(fn ($permission) => $this->permission($permission));
    }

    protected function getRoles(Permission $permission)
    {
        return $permission->is_default
            ? Role::pluck('id')
            : Role::whereName(config('enso.config.defaultRole'))->first()->id;
    }

    private function permission(array $permission)
    {
        $permission = Permission::create($permission);
        $permission->roles()->sync($this->getRoles($permission));
    }
}
