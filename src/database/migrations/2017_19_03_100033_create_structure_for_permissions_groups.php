<?php

use LaravelEnso\Core\App\Classes\StructureManager\StructureMigration;

class CreateStructureForPermissionsGroups extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'system.permissionsGroups', 'description' => 'Permissions Grops Group',
    ];

    protected $permissions = [
        ['name' => 'system.permissionsGroups.index', 'description' => 'Permissions Groups Index', 'type' => 0],
        ['name' => 'system.permissionsGroups.create', 'description' => 'Create Permissions Group', 'type' => 1],
        ['name' => 'system.permissionsGroups.edit', 'description' => 'Edit Existing Permissions Group', 'type' => 1],
        ['name' => 'system.permissionsGroups.store', 'description' => 'Save Permissions Group', 'type' => 1],
        ['name' => 'system.permissionsGroups.update', 'description' => 'Update Permissions Group', 'type' => 1],
        ['name' => 'system.permissionsGroups.destroy', 'description' => 'Delete Permissions Group', 'type' => 1],
        ['name' => 'system.permissionsGroups.getTableData', 'description' => 'Get table data for permissionsgroups', 'type' => 0],
        ['name' => 'system.permissionsGroups.initTable', 'description' => 'Init table data for permissiongroups', 'type' => 0],
    ];

    protected $menu = [
        'name' => 'Permissions Groups', 'icon' => 'fa fa-fw fa-object-group', 'link' => 'system/permissionsGroups', 'has_children' => 0,
    ];

    protected $parentMenu = 'System';
}
