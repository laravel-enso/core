<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForSystem extends StructureMigration
{
    protected $menu = [
        'name' => 'System', 'icon' => 'sliders-h', 'link' => null, 'order_index' => 600, 'has_children' => true,
    ];
}
