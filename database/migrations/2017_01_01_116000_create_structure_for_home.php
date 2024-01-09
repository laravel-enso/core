<?php

use LaravelEnso\Migrator\Database\Migration;

return new class() extends Migration {
    protected array $permissions = [
        ['name' => 'core.home.index', 'description' => 'App State Builder', 'is_default' => true],
    ];
};
