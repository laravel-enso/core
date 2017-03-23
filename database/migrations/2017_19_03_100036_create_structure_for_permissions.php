<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForPermissions extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'system.permissions', 'description' => 'Permissions Group',
    ];

    private $permissions = [
        ['name' => 'system.permissions.index', 'description' => 'Permissions Groups Index', 'type' => 0],
        ['name' => 'system.permissions.create', 'description' => 'Create Permissions Group', 'type' => 1],
        ['name' => 'system.permissions.edit', 'description' => 'Edit Existing Permissions Group', 'type' => 1],
        ['name' => 'system.permissions.store', 'description' => 'Save Permissions Group', 'type' => 1],
        ['name' => 'system.permissions.update', 'description' => 'Update Permissions Group', 'type' => 1],
        ['name' => 'system.permissions.destroy', 'description' => 'Delete Permissions Group', 'type' => 1],
        ['name' => 'system.permissions.getTableData', 'description' => 'Get table data for permissionsgroups', 'type' => 0],
        ['name' => 'system.permissions.initTable', 'description' => 'Init table data for permissiongroups', 'type' => 0],
        ['name' => 'system.resourcePermissions.create', 'description' => 'Create Resource Permission', 'type' => 1],
        ['name' => 'system.resourcePermissions.store', 'description' => 'Store Resource Permission', 'type' => 1],
    ];

    private $menu = [
        'name' => 'Permissions', 'icon' => 'fa fa-fw fa-exclamation-triangle', 'link' => 'system/permissions', 'has_children' => 0,
    ];

    private $parentMenu;
    private $roles;
}
