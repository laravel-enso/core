<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForDashboard extends StructureMigration
{
    protected $permissions = [
        ['name' => 'dashboard.index', 'description' => 'Dashboard page', 'type' => 0, 'is_default' => true],
    ];

    protected $menu = [
        'name' => 'Dashboard', 'icon' => 'tachometer-alt', 'route' => 'dashboard.index', 'order_index' => 100, 'has_children' => false,
    ];
}
