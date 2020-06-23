<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Upgrade\App\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\App\Traits\StructureMigration;

class AddressLocalization implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'core.addresses.localize', 'description' => 'Localize address with google maps', 'is_default' => false],
    ];

    protected $roles = ['admin', 'supervisor'];
}
