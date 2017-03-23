<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForDashboard extends Migration
{
    use MigrationSupport;
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $permissionsGroup = [
        'name' => 'dashboard', 'description' => 'Dashboard Permissions Group',
    ];

    private $permissions = [
        ['name' => 'dashboard', 'description' => 'Dashboard Index Page', 'type' => 0],
    ];

    private $menu = [
        'name' => 'Dashboard', 'icon' => 'fa fa-fw fa-tachometer', 'link' => 'dashboard', 'has_children' => 0,
    ];

    private $parentMenu;
    private $roles;
}
