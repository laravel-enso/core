<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class AddressesPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'core.addresses.options', 'description' => 'Get addresses for select', 'is_default' => false],
        ['name' => 'core.addresses.localities', 'description' => 'Get localities for the select', 'is_default' => false],
        ['name' => 'core.addresses.regions', 'description' => 'Get regions for the select', 'is_default' => false],
        ['name' => 'core.addresses.show', 'description' => 'Get Address', 'is_default' => false],
        ['name' => 'core.addresses.postcode', 'description' => 'Get address based on the postcode', 'is_default' => false],
        ['name' => 'core.addresses.makeShipping', 'description' => 'Make address shipping', 'is_default' => false],
        ['name' => 'core.addresses.makeBilling', 'description' => 'Make address billing', 'is_default' => false],
    ];

    protected $roles = ['admin', 'supervisor'];
}
