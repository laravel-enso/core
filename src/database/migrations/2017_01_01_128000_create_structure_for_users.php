<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForUsers extends Migration
{
    protected $permissions = [
        ['name' => 'administration.users.initTable', 'description' => 'Init table for users', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.users.tableData', 'description' => 'Get table data for users', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.users.exportExcel', 'description' => 'Export excel for users', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.users.options', 'description' => 'Get options for select', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.users.create', 'description' => 'Create user', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.users.edit', 'description' => 'Edit existing user', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.users.index', 'description' => 'Show users', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.users.show', 'description' => 'Display user information', 'type' => Types::Read, 'is_default' => true],
        ['name' => 'administration.users.store', 'description' => 'Store newly created user', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.users.update', 'description' => 'Update edited user', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.users.destroy', 'description' => 'Delete user', 'type' => Types::Write, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Users', 'icon' => 'user', 'route' => 'administration.users.index', 'order_index' => 100, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
