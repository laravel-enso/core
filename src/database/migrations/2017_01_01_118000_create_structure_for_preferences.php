<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForPreferences extends Migration
{
    protected $permissions = [
        ['name' => 'core.preferences.store', 'description' => "Set user's preferences", 'type' => Types::Write, 'is_default' => true],
        ['name' => 'core.preferences.reset', 'description' => 'Reset preferences to default', 'type' => Types::Write, 'is_default' => true],
    ];
}
