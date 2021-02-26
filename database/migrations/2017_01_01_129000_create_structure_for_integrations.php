<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForIntegrations extends Migration
{
    protected array $menu = [
        'name' => 'Integrations', 'icon' => 'plug', 'route' => null, 'order_index' => 1000, 'has_children' => true,
    ];
}
