<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from 3.* to 4.*';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        \DB::transaction(function () {
            $this->updateNotificationPermissions();
        });
    }

    private function updateNotificationPermissions()
    {
        $this->info('Updating notification permissions');

        Permission::whereName('core.notifications.update')
            ->update(['name' => 'core.notifications.read']);
        Permission::whereName('core.notifications.updateAll')
            ->update(['name' => 'core.notifications.readAll']);

        $this->info('Notification permissions successfuly updated');

        return $this;
    }
}
