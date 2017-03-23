<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForAdministration extends Migration
{
    use MigrationSupport;
    /**
     * Run the migrations.
     *
     * @return void
     */

    private $permissionsGroup;

    private $permissions;

    private $menu = [
        'name' => 'Administration', 'icon' => 'fa fa-fw fa-cogs', 'link' => null, 'has_children' => 1
    ];

    private $parentMenu;
    private $roles;
}
