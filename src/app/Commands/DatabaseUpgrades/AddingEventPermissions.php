<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

class AddingEventPermissions extends StructureUpgrade
{
    protected $permissions = [
        ['name' => 'core.calendar.events.index', 'description' => 'Get events', 'type' => 0, 'is_default' => true],
    ];
}
