<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Classes\StructureManager\StructureSupport;

class CreateStructureForAdministration extends Migration
{
    use StructureSupport;
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $permissionsGroup;

    private $permissions;

    private $menu = [
        'name' => 'Administration', 'icon' => 'fa fa-fw fa-cogs', 'link' => null, 'has_children' => 1,
    ];

    private $parentMenu;
    private $roles;
}
