<?php

namespace LaravelEnso\Core\Services\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class DataImportPermissions implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'import.show', 'description' => 'Get import', 'is_default' => false],
    ];

    protected $roles = ['admin', 'supervisor'];
}
