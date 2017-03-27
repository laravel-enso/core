<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForAvatars extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'core.avatars', 'description' => 'Avatars Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'core.avatars.destroy', 'description' => 'Delete Avatar', 'type' => 1],
        ['name' => 'core.avatars.show', 'description' => 'Return Selected Avatar', 'type' => 0],
        ['name' => 'core.avatars.store', 'description' => 'Upload Avatar', 'type' => 1],
    ];
}
