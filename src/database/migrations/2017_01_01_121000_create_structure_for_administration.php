<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForAdministration extends StructureMigration
{
    protected $menu = [
        'name' => 'Administration', 'icon' => 'fas fa-fw fa-cogs', 'link' => null, 'has_children' => true,
    ];
}
