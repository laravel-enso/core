<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Classes\StructureManager\StructureSupport;

class CreateStructureForAvatars extends Migration
{
    use StructureSupport;

    private $permissionsGroup = [
        'name' => 'core.avatars', 'description' => 'Avatars Permissions Group',
    ];

    private $permissions = [
        ['name' => 'core.avatars.destroy', 'description' => 'Delete Avatar', 'type' => 1],
        ['name' => 'core.avatars.show', 'description' => 'Return Selected Avatar', 'type' => 0],
        ['name' => 'core.avatars.store', 'description' => 'Upload Avatar', 'type' => 1],
    ];

    private $menu;
    private $parentMenu;
    private $roles;
}
