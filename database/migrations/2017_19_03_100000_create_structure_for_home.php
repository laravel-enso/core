<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForHome extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'core.home', 'description' => 'Home Permissions Group',
    ];

    private $permissions = [
        ['name' => 'home', 'description' => 'Welcome Page', 'type' => 0],
    ];

    // private $menu;
    // private $parentMenu;
    // private $roles;
}
