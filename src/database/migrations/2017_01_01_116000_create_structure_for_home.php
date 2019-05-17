<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForHome extends Migration
{
    protected $permissions = [
        ['name' => 'core.home.index', 'description' => 'App State Builder', 'type' => 0, 'is_default' => true],
    ];
}
