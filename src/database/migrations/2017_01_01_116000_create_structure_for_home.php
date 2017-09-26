<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForHome extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'core.home', 'description' => 'Home permissions group',
    ];

    protected $permissions = [
        ['name' => 'home', 'description' => 'Welcome Page', 'type' => 0, 'default' => true],
        ['name' => 'init', 'description' => 'App State Builder', 'type' => 0, 'default' => true],
    ];
}
