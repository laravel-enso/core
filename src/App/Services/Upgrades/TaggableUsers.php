<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Upgrade\App\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\App\Traits\StructureMigration;

class TaggableUsers implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'core.comments.users', 'description' => 'Get taggable users options for select', 'is_default' => true],
    ];
}
