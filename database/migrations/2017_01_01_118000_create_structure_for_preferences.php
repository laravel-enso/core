<?php

use LaravelEnso\Migrator\Database\Migration;

return new class() extends Migration {
    protected array $permissions = [
        ['name' => 'core.preferences.store', 'description' => "Set user's preferences", 'is_default' => true],
        ['name' => 'core.preferences.reset', 'description' => 'Reset preferences to default', 'is_default' => true],
    ];
};
