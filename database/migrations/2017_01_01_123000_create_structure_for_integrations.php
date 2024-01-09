<?php

use LaravelEnso\Migrator\Database\Migration;

return new class() extends Migration {
    protected array $menu = [
        'name' => 'Integrations', 'icon' => 'fas puzzle-piece', 'route' => null, 'order_index' => 700, 'has_children' => true,
    ];
};
