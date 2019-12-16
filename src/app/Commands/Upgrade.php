<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CurrenciesUpgrade;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade any necessary packages from the previous release';

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        (new CurrenciesUpgrade())->handle();
    }
}
