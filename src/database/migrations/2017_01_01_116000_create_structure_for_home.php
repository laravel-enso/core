<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForHome extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'core.home', 'description' => 'Home permissions group',
    ];

    protected $permissions = [
        ['name' => 'core.index', 'description' => 'App State Builder', 'type' => 0, 'is_default' => true],
    ];
}
