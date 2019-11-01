<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

class AddNewCalendarPermissions extends StructureUpgrade
{
    protected $permissions = [
        ['name' => 'core.calendar.create', 'description' => 'Create a new calendar', 'type' => 0, 'is_default' => true],
        ['name' => 'core.calendar.store', 'description' => 'Store a new calendar', 'type' => 1, 'is_default' => true],
        ['name' => 'core.calendar.edit', 'description' => 'Edit calendar', 'type' => 0, 'is_default' => true],
        ['name' => 'core.calendar.update', 'description' => 'Update calendar', 'type' => 1, 'is_default' => true],
        ['name' => 'core.calendar.destroy', 'description' => 'Delete calendar', 'type' => 1, 'is_default' => true],
        ['name' => 'core.calendar.index', 'description' => 'Get calendars', 'type' => 0, 'is_default' => true],
        ['name' => 'core.calendar.options', 'description' => 'Get options for select', 'type' => 0, 'is_default' => true],
    ];
}
