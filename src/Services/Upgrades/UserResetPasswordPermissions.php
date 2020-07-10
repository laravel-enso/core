<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class UserResetPasswordPermissions implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.users.resetPassword', 'description' => 'Manually Reset password for the user', 'is_default' => false],
    ];

    protected array $roles = ['admin', 'supervisor'];
}
