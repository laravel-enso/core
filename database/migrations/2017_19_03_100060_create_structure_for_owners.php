<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForOwners extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'administration.owners', 'description' => 'Owners Permissions Group',
    ];

    private $permissions = [
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

    private $menu = [
        'name' => 'Owners', 'icon' => 'fa fa-fw fa-list-alt', 'link' => 'administration/owners', 'has_children' => 0,
    ];

    // private $parentMenu = 'Administration';
    // private $roles;
}
