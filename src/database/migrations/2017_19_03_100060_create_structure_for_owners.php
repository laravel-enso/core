<?php

use LaravelEnso\Core\App\Classes\StructureManager\StructureMigration;

class CreateStructureForOwners extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'administration.owners', 'description' => 'Owners Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'administration.owners.initTable', 'description' => 'Init table for owners menu', 'type' => 0],
        ['name' => 'administration.owners.getTableData', 'description' => 'Get table data for owners', 'type' => 0],
        ['name' => 'administration.owners.create', 'description' => 'Create Owner', 'type' => 1],
        ['name' => 'administration.owners.edit', 'description' => 'Edit Existing Owner', 'type' => 1],
        ['name' => 'administration.owners.index', 'description' => 'Show Owners', 'type' => 0],
        ['name' => 'administration.owners.getOptionsList', 'description' => 'Get Options List For Vue Select', 'type' => 0],
        ['name' => 'administration.owners.store', 'description' => 'Save Owner', 'type' => 1],
        ['name' => 'administration.owners.update', 'description' => 'Update Owner', 'type' => 1],
        ['name' => 'administration.owners.destroy', 'description' => 'Delete Owner', 'type' => 1],
    ];

    protected $menu = [
        'name' => 'Owners', 'icon' => 'fa fa-fw fa-list-alt', 'link' => 'administration/owners', 'has_children' => 0,
    ];

    protected $parentMenu = 'Administration';
}
