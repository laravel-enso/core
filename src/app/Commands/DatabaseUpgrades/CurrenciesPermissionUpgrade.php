<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\App\Enums\Types;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Enums\Roles;

class CurrenciesPermissionUpgrade extends StructureUpgrade
{
    protected $permission = [
        'name' => 'administration.currencies.convert',
        'description' => 'Convert from one currency to another',
        'type' => Types::Read,
        'is_default' => false,
    ];

    protected function isMigrated()
    {
        return ! Schema::hasTable('currencies')
            || Permission::whereName($this->permission['name'])->exists();
    }

    protected function migrateData()
    {
        Permission::create($this->permission)
            ->roles()->sync(Roles::Admin);
    }
}
