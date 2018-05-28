<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForPreferences extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'core.preferences', 'description' => 'Preferences permissions group',
    ];

    protected $permissions = [
        ['name' => 'core.preferences.setPreferences', 'description' => 'Set user\'s preferences', 'type' => 1, 'is_default' => true],
        ['name' => 'core.preferences.resetToDefault', 'description' => 'Reset preferences to default', 'type' => 1, 'is_default' => true],
    ];
}
