<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForOwners extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'administration.owners', 'description' => 'Owners permissions group',
    ];

    protected $permissions = [
        ['name' => 'administration.owners.initTable', 'description' => 'Init table for owners menu', 'type' => 0, 'default' => false],
        ['name' => 'administration.owners.getTableData', 'description' => 'Get table data for owners', 'type' => 0, 'default' => false],
        ['name' => 'administration.owners.exportExcel', 'description' => 'Export excel for owners', 'type' => 0, 'default' => false],
        ['name' => 'administration.owners.create', 'description' => 'Create owner', 'type' => 1, 'default' => false],
        ['name' => 'administration.owners.edit', 'description' => 'Edit existing owner', 'type' => 1, 'default' => false],
        ['name' => 'administration.owners.index', 'description' => 'Show owners index', 'type' => 0, 'default' => false],
        ['name' => 'administration.owners.selectOptions', 'description' => 'Get options for vue-select', 'type' => 0, 'default' => false],
        ['name' => 'administration.owners.store', 'description' => 'Store a newly created owner', 'type' => 1, 'default' => false],
        ['name' => 'administration.owners.update', 'description' => 'Update edited Owner', 'type' => 1, 'default' => false],
        ['name' => 'administration.owners.destroy', 'description' => 'Delete owner', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Owners', 'icon' => 'list-alt', 'link' => 'administration.owners.index', 'order' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
