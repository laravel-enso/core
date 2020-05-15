<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Upgrade\App\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\App\Traits\StructureMigration;

class TaggableUsers implements MigratesStructure
{
    use StructureMigration;

    protected $permissions = [
        ['name' => 'administration.users.taggableOptions', 'description' => 'Get taggable options for select', 'is_default' => false],
    ]; //core.comments.users
}
