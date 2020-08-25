<?php

namespace LaravelEnso\Core\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class LocalisationPermission implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        [
            'name' => 'system.localisation.options', 'description' => 'Get options for select', 'is_default' => true,
        ],
    ];

    protected $roles = ['admin', 'supervisor'];
}
