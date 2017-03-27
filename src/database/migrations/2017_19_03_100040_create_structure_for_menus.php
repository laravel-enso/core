<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForMenus extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'system.menus', 'description' => 'Menus Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'system.menus.getTableData', 'description' => 'Get table data for menus', 'type' => 0],
        ['name' => 'system.menus.initTable', 'description' => 'Init table for menus menu', 'type' => 0],
        ['name' => 'system.menus.create', 'description' => 'Create Menu', 'type' => 1],
        ['name' => 'system.menus.edit', 'description' => 'Edit Existing Menu', 'type' => 1],
        ['name' => 'system.menus.index', 'description' => 'Show Menus', 'type' => 0],
        ['name' => 'system.menus.reorder', 'description' => 'Reorder Menus', 'type' => 1],
        ['name' => 'system.menus.setOrder', 'description' => 'Set New Menus Order', 'type' => 1],
        ['name' => 'system.menus.store', 'description' => 'Save Menu', 'type' => 1],
        ['name' => 'system.menus.update', 'description' => 'Update Menu', 'type' => 1],
        ['name' => 'system.menus.destroy', 'description' => 'Delete Menu', 'type' => 1],
    ];

    protected $menu = [
        'name' => 'Menus', 'icon' => 'fa fa-fw fa-list', 'link' => 'system/menus', 'has_children' => 0,
    ];

    protected $parentMenu = 'System';
}
