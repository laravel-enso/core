<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Upgrade\App\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\App\Traits\StructureMigration;

class UserPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'administration.users.token', 'description' => 'Generate token for user', 'is_default' => false],
    ];

    protected $roles = ['admin'];
}
