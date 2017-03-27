<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForPreferences extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'core.preferences', 'description' => 'Avatars Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'core.preferences.setPreferences', 'description' => 'Set User Preferences', 'type' => 1],
        ['name' => 'core.preferences.resetToDefaut', 'description' => 'Reset to default preferences', 'type' => 1],
    ];
}
