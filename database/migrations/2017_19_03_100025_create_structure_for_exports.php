<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForExports extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'core.export', 'description' => 'Exports Permissions Group',
    ];

    private $permissions = [
        ['name' => 'core.export.getUsers', 'description' => 'Generates an xls users export and sends it by email to the user that made the request', 'type' => 1],
    ];

    private $menu;
    private $parentMenu;
    private $roles;
}
