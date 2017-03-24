<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Classes\StructureManager\StructureSupport;

class CreateStructureForPreferences extends Migration
{
    use StructureSupport;

    private $permissionsGroup = [
        'name' => 'core.preferences', 'description' => 'Avatars Permissions Group',
    ];

    private $permissions = [
        ['name' => 'core.preferences.setPreferences', 'description' => 'Set User Preferences', 'type' => 1],
        ['name' => 'core.preferences.resetToDefaut', 'description' => 'Reset to default preferences', 'type' => 1],
    ];

    private $menu;
    private $parentMenu;
    private $roles;
}
