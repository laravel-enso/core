<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration
{
    protected array $menu = [
        'name' => 'System', 'icon' => 'sliders-h', 'route' => null, 'order_index' => 600, 'has_children' => true,
    ];
};
