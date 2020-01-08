<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Collection;
use LaravelEnso\Permissions\App\Models\Permission;

class AddressesUpgrade extends StructureUpgrade
{
    protected $permissions = [
        'core.addresses.setDefault' => 'core.addresses.makeDefault',
    ];

    protected function isMigrated()
    {
        return Permission::whereName('core.addresses.makeDefault')->exists();
    }

    protected function migrateData()
    {
        (new Collection($this->permissions))
            ->each(fn ($new, $old) => Permission::whereName($old)->update(['name' => $new]));
    }
}
