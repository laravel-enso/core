<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class UserSessionPermissions implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.users.sessions.destroy', 'description' => 'Delete token', 'is_default' => false],
        ['name' => 'administration.users.sessions.index', 'description' => 'Get Tokens', 'is_default' => false],
    ];

    protected array $roles = ['admin', 'supervisor'];
}
