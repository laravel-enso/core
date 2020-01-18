<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\AddressesNamespaceUpdate;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\AddressesUpgrade;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\CommentsNamespaceUpdate;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\CurrenciesPermissionUpgrade;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\CurrenciesUpgrade;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\DiscussionsNamespaceUpdate;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\DocumentsNamespaceUpdate;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\DocumentsUpgrade;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\FilesNamespaceUpdate;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\MenusUpgrade;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\RolesUpgrade;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso from v3.7.* to 3.8.*';

    private $upgrades = [
        DocumentsUpgrade::class,
        AddressesUpgrade::class,
        RolesUpgrade::class,
        MenusUpgrade::class,
        FilesNamespaceUpdate::class,
        AddressesNamespaceUpdate::class,
        CommentsNamespaceUpdate::class,
        CurrenciesUpgrade::class,
        CurrenciesPermissionUpgrade::class,
        DocumentsNamespaceUpdate::class,
        DiscussionsNamespaceUpdate::class,
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
