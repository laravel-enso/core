<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CalendarUpgrade;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from v3.3.* to 3.4.*';

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        (new CalendarUpgrade())->handle();
    }
}
