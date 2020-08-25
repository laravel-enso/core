<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Support\Collection;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class ControlPanelApiPermission implements MigratesData
{
    private array $permissions = [
        'api.controlPanelApi.statistics' => 'apis.controlPanel.statistics',
        'api.controlPanelApi.actions' => 'apis.controlPanel.actions',
        'api.controlPanelApi.action' => 'apis.controlPanel.action',
    ];

    public function migrateData(): void
    {
        (new Collection($this->permissions))
            ->each(fn ($to, $from) => Permission::whereName($from)->update(['name' => $to]));
    }

    public function isMigrated(): bool
    {
        return Permission::whereIn('name', array_keys($this->permissions))->doesntExist();
    }
}
