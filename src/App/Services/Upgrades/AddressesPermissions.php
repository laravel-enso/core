<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Upgrade\App\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\App\Traits\StructureMigration;

class AddressesPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'core.addresses.options', 'description' => 'Get addresses for select', 'is_default' => false],
        ['name' => 'core.addresses.localities', 'description' => 'Get localities for the select', 'is_default' => false],
        ['name' => 'core.addresses.regions', 'description' => 'Get regions for the select', 'is_default' => false],
    ];

    protected $roles = ['admin', 'supervisor'];
}
