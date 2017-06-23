<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForSystem extends StructureMigration
{
    protected $menu = [
        'name' => 'System', 'icon' => 'fa fa-fw fa-sliders', 'link' => null, 'has_children' => true,
    ];
}
