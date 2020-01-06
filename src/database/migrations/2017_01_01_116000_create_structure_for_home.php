<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForHome extends Migration
{
    protected $permissions = [
        ['name' => 'core.home.index', 'description' => 'App State Builder', 'type' => Types::Read, 'is_default' => true],
    ];
}
