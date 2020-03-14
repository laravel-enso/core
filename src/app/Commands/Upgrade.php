<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\Permissions;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso from v3.7.* to 3.8.*';

    private $upgrades = [
        Permissions::class,
    ];

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        collect($this->upgrades)
            ->each(fn ($upgrade) => (new $upgrade())->handle());
    }
}
