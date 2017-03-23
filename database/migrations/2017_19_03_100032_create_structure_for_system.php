<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForSystem extends Migration
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
        'name' => 'System', 'icon' => 'fa fa-fw fa-sliders', 'link' => null, 'has_children' => 1
    ];

    private $parentMenu;
    private $roles;
}
