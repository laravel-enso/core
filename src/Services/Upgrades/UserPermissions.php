<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class UserPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'administration.users.token', 'description' => 'Generate token for user', 'is_default' => false],
    ];

    protected $roles = ['admin'];
}
