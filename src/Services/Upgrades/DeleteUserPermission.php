<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class DeleteUserPermission implements MigratesData
{
    protected $roles = ['admin'];

    public function migrateData(): void
    {
        Permission::whereName('administration.users.token')->delete();
    }

    public function isMigrated(): bool
    {
        return Permission::whereName('administration.users.token')->doesntExist();
    }
}
