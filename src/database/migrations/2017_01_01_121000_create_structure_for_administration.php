<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAdministration extends StructureMigration
{
    protected $menu = [
        'name' => 'Administration', 'icon' => 'cogs', 'route' => null, 'order_index' => 500, 'has_children' => true,
    ];
}
