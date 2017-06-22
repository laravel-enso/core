<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForPreferences extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'core.preferences', 'description' => 'Avatars Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'core.preferences.setPreferences', 'description' => 'Set User Preferences', 'type' => 1, 'default' => true],
        ['name' => 'core.preferences.resetToDefalut', 'description' => 'Reset to default preferences', 'type' => 1, 'default' => true],
    ];
}
