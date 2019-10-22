<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\FilesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\RenameEvents;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\PeopleUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\RenameReminders;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CompaniesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\DataImportUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\RenamePermissions;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\VersioningUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\InvoiceLineUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\RoAddressesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\AddingCalendarToEvents;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\AddingEventPermissions;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\AddingCalendarPermissions;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\AddingInvoiceLinePermissions;

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
        (new RoAddressesUpgrade())->migrate();
        (new PeopleUpgrade())->migrate();
        (new CompaniesUpgrade())->migrate();
        (new DataImportUpgrade())->migrate();
        (new FilesUpgrade())->migrate();
        (new VersioningUpgrade())->migrate();
        (new RenamePermissions($this))->handle();
        (new AddingCalendarPermissions())->handle();
        (new RenameEvents())->handle();
        (new RenameReminders())->handle();
        (new AddingCalendarToEvents())->handle();
        (new AddingEventPermissions())->handle();

        if (Schema::hasTable('client_invoices')) {
            (new InvoiceLineUpgrade())->migrate();
            (new AddingInvoiceLinePermissions())->migrate();
        }
    }
}
