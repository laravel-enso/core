<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForRoles extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'system.roles', 'description' => 'Roles Permissions Group',
    ];

    private $permissions = [
        ['name' => 'system.roles.getTableData', 'description' => 'Get table data for roles', 'type' => 0],
        ['name' => 'system.roles.initTable', 'description' => 'Init table for roles menu', 'type' => 0],
        ['name' => 'system.roles.create', 'description' => 'Create Role', 'type' => 1],
        ['name' => 'system.roles.edit', 'description' => 'Edit Existing Role', 'type' => 1],
        ['name' => 'system.roles.index', 'description' => 'Show Roles List', 'type' => 0],
        ['name' => 'system.roles.store', 'description' => 'Save Role', 'type' => 1],
        ['name' => 'system.roles.update', 'description' => 'Update Role', 'type' => 1],
        ['name' => 'system.roles.destroy', 'description' => 'Delete Role', 'type' => 1],
        ['name' => 'system.roles.getOptionsList', 'description' => 'Get Permissions for Role', 'type' => 1],
        ['name' => 'system.roles.getPermissions', 'description' => 'Get Role Permissions', 'type' => 0],
        ['name' => 'system.roles.setPermissions', 'description' => 'Set Permissions for Role', 'type' => 1],
    ];

    private $menu = [
        'name' => 'Roles', 'icon' => 'fa fa-fw fa-universal-access', 'link' => 'system/roles', 'has_children' => 0,
    ];

    // private $parentMenu;
    // private $roles;
}
