<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForDashboard extends Migration
{
    protected $permissions = [
        ['name' => 'dashboard.index', 'description' => 'Dashboard page', 'type' => Types::Read, 'is_default' => true],
    ];

    protected $menu = [
        'name' => 'Dashboard', 'icon' => 'tachometer-alt', 'route' => 'dashboard.index', 'order_index' => 100, 'has_children' => false,
    ];
}
