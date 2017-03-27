<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForDashboard extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'dashboard', 'description' => 'Dashboard Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'dashboard', 'description' => 'Dashboard Index Page', 'type' => 0],
    ];

    protected $menu = [
        'name' => 'Dashboard', 'icon' => 'fa fa-fw fa-tachometer', 'link' => 'dashboard', 'has_children' => 0,
    ];
}
