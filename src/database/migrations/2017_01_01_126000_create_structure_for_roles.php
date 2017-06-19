<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForRoles extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'system.roles', 'description' => 'Roles Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'system.roles.getTableData', 'description' => 'Get table data for roles', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.initTable', 'description' => 'Init table for roles menu', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.create', 'description' => 'Create Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.edit', 'description' => 'Edit Existing Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.index', 'description' => 'Show Roles List', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.store', 'description' => 'Save Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.update', 'description' => 'Update Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.destroy', 'description' => 'Delete Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.getOptionsList', 'description' => 'Get Permissions for Role', 'type' => 1, 'default' => false],
        ['name' => 'system.roles.getPermissions', 'description' => 'Get Role Permissions', 'type' => 0, 'default' => false],
        ['name' => 'system.roles.setPermissions', 'description' => 'Set Permissions for Role', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Roles', 'icon' => 'fa fa-fw fa-universal-access', 'link' => 'system/roles', 'has_children' => 0,
    ];

    protected $parentMenu = 'System';
}
