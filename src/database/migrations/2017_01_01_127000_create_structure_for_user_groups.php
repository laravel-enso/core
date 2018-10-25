<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForUserGroups extends StructureMigration
{
    protected $permissions = [
        ['name' => 'administration.userGroups.initTable', 'description' => 'Init table for userGroups', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.userGroups.tableData', 'description' => 'Get table data for userGroups', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.userGroups.exportExcel', 'description' => 'Export excel for userGroups', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.userGroups.create', 'description' => 'Create user group', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.userGroups.edit', 'description' => 'Edit existing user group', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.userGroups.index', 'description' => 'Show userGroups index', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.userGroups.options', 'description' => 'Get options for select', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.userGroups.store', 'description' => 'Store a newly created user group', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.userGroups.update', 'description' => 'Update edited user group', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.userGroups.destroy', 'description' => 'Delete user group', 'type' => 1, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'User Groups', 'icon' => 'users', 'route' => 'administration.userGroups.index', 'order_index' => 500, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
