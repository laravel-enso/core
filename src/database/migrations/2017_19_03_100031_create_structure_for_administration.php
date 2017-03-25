<?php

use LaravelEnso\Core\App\Classes\StructureManager\StructureMigration;

class CreateStructureForAdministration extends StructureMigration
{
    protected $menu = [
        'name' => 'Administration', 'icon' => 'fa fa-fw fa-cogs', 'link' => null, 'has_children' => 1,
    ];
}
