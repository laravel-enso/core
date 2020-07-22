<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class UserTokenPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [ //TODO :: Update migration too
        ['name' => 'administration.users.tokens.create', 'description' => 'Create Token', 'is_default' => false],
        ['name' => 'administration.users.tokens.store', 'description' => 'Generate token for user', 'is_default' => false],
        ['name' => 'administration.users.tokens.destroy', 'description' => 'Delete token', 'is_default' => false],
        ['name' => 'administration.users.tokens.index', 'description' => 'Get Tokens', 'is_default' => false],
    ];

    protected $roles = ['admin'];
}
