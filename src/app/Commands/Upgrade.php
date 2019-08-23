<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\PeopleUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CompaniesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\InvoiceLineUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\AddingInvoiceLinePermissions;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core from v3.3.* to the latest version';

    public function handle()
    {
        $this->upgrade();
    }

    private function upgrade()
    {
        (new InvoiceLineUpgrade())->migrate();
        (new PeopleUpgrade())->migrate();
        (new CompaniesUpgrade())->migrate();
        (new AddingInvoiceLinePermissions())->migrate();
    }

}
