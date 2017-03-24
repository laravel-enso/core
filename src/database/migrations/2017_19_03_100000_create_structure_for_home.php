<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Classes\StructureManager\StructureSupport;

class CreateStructureForHome extends Migration
{
    use StructureSupport;

    private $permissionsGroup = [
        'name' => 'core.home', 'description' => 'Home Permissions Group',
    ];

    private $permissions = [
        ['name' => 'home', 'description' => 'Welcome Page', 'type' => 0],
    ];

    private $menu;
    private $parentMenu;
    private $roles;
}
