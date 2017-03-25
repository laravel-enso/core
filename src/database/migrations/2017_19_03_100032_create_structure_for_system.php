<?php

use LaravelEnso\Core\App\Classes\StructureManager\StructureMigration;

class CreateStructureForSystem extends StructureMigration
{
    protected $menu = [
        'name' => 'System', 'icon' => 'fa fa-fw fa-sliders', 'link' => null, 'has_children' => 1,
    ];
}
