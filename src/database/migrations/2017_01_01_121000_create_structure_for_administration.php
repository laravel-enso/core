<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAdministration extends StructureMigration
{
    protected $menu = [
        'name' => 'Administration', 'icon' => 'cogs', 'link' => null, 'order_index' => 999, 'has_children' => true,
    ];
}
