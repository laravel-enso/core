<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForUsers extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'administration.users', 'description' => 'Users Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'administration.users.initTable', 'description' => 'Init Table for Users', 'type' => 0, 'default' => false],
        ['name' => 'administration.users.getTableData', 'description' => 'Get Table Data', 'type' => 0, 'default' => false],
        ['name' => 'administration.users.setTableData', 'description' => 'Set data for users', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.create', 'description' => 'Create User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.edit', 'description' => 'Edit Existing User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.index', 'description' => 'Show Users', 'type' => 0, 'default' => false],
        ['name' => 'administration.users.show', 'description' => 'Display User Information', 'type' => 0, 'default' => false],
        ['name' => 'administration.users.store', 'description' => 'Save User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.update', 'description' => 'Update User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.destroy', 'description' => 'Delete User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.updateProfile', 'description' => 'Update User\'s Profile', 'type' => 1, 'default' => true],
        ['name' => 'administration.users.stopImpersonating', 'description' => 'Stop Impersonating User', 'type' => 1, 'default' => false],
        ['name' => 'administration.users.impersonate', 'description' => 'Impersonate User', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Users', 'icon' => 'fa fa-fw fa-users', 'link' => 'administration/users', 'has_children' => 0,
    ];

    protected $parentMenu = 'Administration';
}
