<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Console\Command;
use LaravelEnso\Permissions\app\Models\Permission;

class RenamePermissions
{
    private $console;

    public function __construct(Command $console)
    {
        $this->console = $console;
    }

    public function handle()
    {
        $this->console->info('Renaming permissions');

        Permission::whereName('core.preferences.setPreferences')
            ->update(['name' => 'core.preferences.store']);

        Permission::whereName('core.preferences.setDefaultPreferences')
            ->update(['name' => 'core.preferences.reset']);

        $this->console->info('Permissions successfully renamed');
    }
}
