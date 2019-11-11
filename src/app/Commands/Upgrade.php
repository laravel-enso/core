<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CalendarUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CountriesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\TutorialUpgrade;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from v3.6.* to 3.7.*';

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        (new CalendarUpgrade())->handle();
        (new CountriesUpgrade())->handle();
        (new TutorialUpgrade())->handle();
    }
}
