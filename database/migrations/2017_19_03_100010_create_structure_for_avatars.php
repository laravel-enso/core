<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Classes\MigrationSupport\MigrationSupport;

class CreateStructureForAvatars extends Migration
{
    use MigrationSupport;

    private $permissionsGroup = [
        'name' => 'core.avatars', 'description' => 'Avatars Permissions Group',
    ];

    private $permissions = [
        ['name' => 'core.avatars.destroy', 'description' => 'Delete Avatar', 'type' => 1],
        ['name' => 'core.avatars.show', 'description' => 'Return Selected Avatar', 'type' => 0],
        ['name' => 'core.avatars.store', 'description' => 'Upload Avatar', 'type' => 1],
        ['name' => 'core.export.getUsers', 'description' => 'Generate Users Export', 'type' => 0],
    ];

    private $menu;
    private $parentMenu;
    private $roles;
}
