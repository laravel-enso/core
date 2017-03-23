<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForUsers extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'administration.users', 'description' => 'Users Permissions Group',
    ];

    private $permissions = [
        ['name' => 'administration.users.initTable', 'description' => 'Init Table for Users', 'type' => 0],
        ['name' => 'administration.users.getTableData', 'description' => 'Get Table Data', 'type' => 0],
        ['name' => 'administration.users.setTableData', 'description' => 'Set data for users', 'type' => 1],
        ['name' => 'administration.users.create', 'description' => 'Create User', 'type' => 1],
        ['name' => 'administration.users.edit', 'description' => 'Edit Existing User', 'type' => 1],
        ['name' => 'administration.users.index', 'description' => 'Show Users', 'type' => 0],
        ['name' => 'administration.users.show', 'description' => 'Display User Information', 'type' => 0],
        ['name' => 'administration.users.store', 'description' => 'Save User', 'type' => 1],
        ['name' => 'administration.users.update', 'description' => 'Update User', 'type' => 1],
        ['name' => 'administration.users.destroy', 'description' => 'Delete User', 'type' => 1],
        ['name' => 'administration.users.updateProfile', 'description' => 'Update User\'s Profile', 'type' => 1],
        ['name' => 'administration.users.stopImpersonating', 'description' => 'Stop Impersonating User', 'type' => 1],
        ['name' => 'administration.users.impersonate', 'description' => 'Impersonate User', 'type' => 1],
    ];

    private $menu = [
        'name' => 'Users', 'icon' => 'fa fa-fw fa-users', 'link' => 'administration/users', 'has_children' => 0
    ];

    private $parentMenu = 'Administration';
    private $roles;
}
