<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForUsers extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'administration.users', 'description' => 'Users permissions group',
    ];

    protected $permissions = [
        ['name' => 'administration.users.initTable', 'description' => 'Init table for users', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.users.getTableData', 'description' => 'Get table data for users', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.users.exportExcel', 'description' => 'Export excel for users', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.users.selectOptions', 'description' => 'Get options for vue-select', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.users.create', 'description' => 'Create user', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.users.edit', 'description' => 'Edit existing user', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.users.index', 'description' => 'Show users', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.users.show', 'description' => 'Display user information', 'type' => 0, 'is_default' => true],
        ['name' => 'administration.users.store', 'description' => 'Store newly created user', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.users.update', 'description' => 'Update edited user', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.users.destroy', 'description' => 'Delete user', 'type' => 1, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Users', 'icon' => 'users', 'link' => 'administration.users.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
