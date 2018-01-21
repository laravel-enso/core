<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForSystem extends StructureMigration
{
    protected $menu = [
        'name' => 'System', 'icon' => 'fas fa-fw fa-sliders-h', 'link' => null, 'has_children' => true,
    ];
}
