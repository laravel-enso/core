<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class AddressLocalization implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'core.addresses.localize', 'description' => 'Localize address with google maps', 'is_default' => false],
    ];

    protected $roles = ['admin', 'supervisor'];
}
