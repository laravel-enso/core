<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\FilesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\PeopleUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\CompaniesUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\VersioningRename;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\DataImportUpgrade;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\RenamePermissions;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\InvoiceLineUpgrade;
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
        (new PeopleUpgrade())->migrate();
        (new CompaniesUpgrade())->migrate();
        (new DataImportUpgrade())->migrate();
        (new FilesUpgrade())->migrate();
        (new VersioningRename($this))->handle();
        (new RenamePermissions($this))->handle();

        if (Schema::hasTable('client_invoices')) {
            (new InvoiceLineUpgrade())->migrate();
            (new AddingInvoiceLinePermissions())->migrate();
        }
    }
}
