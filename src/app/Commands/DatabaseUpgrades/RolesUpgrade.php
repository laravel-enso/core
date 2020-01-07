<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Collection;
use LaravelEnso\Permissions\App\Models\Permission;

class RolesUpgrade extends StructureUpgrade
{
    protected $permissions = [
        'system.roles.getPermissions' => 'system.roles.permissions.get',
        'system.roles.setPermissions' => 'system.roles.permissions.set',
        'system.roles.writeConfig' => 'system.roles.permissions.write',
    ];

    protected function isMigrated()
    {
        return Permission::whereName('system.roles.permissions.get')->exists();
    }

    protected function migrateData()
    {
        Permission::whereName('core.addresses.countryOptions')
            ->update(['name' => 'core.countries.options']);

        (new Collection($this->permissions))
            ->each(fn ($new, $old) => Permission::whereName($old)->update(['name' => $new]));
    }
}
