<?php

use LaravelEnso\Migrator\Database\Migration;

return new class() extends Migration {
    protected array $permissions = [
        ['name' => 'system.logins.index', 'description' => 'Show index for logins', 'is_default' => false],
        ['name' => 'system.logins.initTable', 'description' => 'Init table for logins', 'is_default' => false],
        ['name' => 'system.logins.tableData', 'description' => 'Get table data for logins', 'is_default' => false],
        ['name' => 'system.logins.exportExcel', 'description' => 'Export excel for logins', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Logins', 'icon' => 'right-to-bracket', 'route' => 'system.logins.index', 'order_index' => 152, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'System';
};
