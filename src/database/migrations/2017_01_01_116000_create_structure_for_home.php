<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForHome extends StructureMigration
{
    protected $permissions = [
        ['name' => 'core.home.index', 'description' => 'App State Builder', 'type' => 0, 'is_default' => true],
    ];
}
