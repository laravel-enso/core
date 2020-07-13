<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\App\Services\Upgrades\PosterMorphKey;
use LaravelEnso\Core\Services\Upgrades\Addresses;
use LaravelEnso\Core\Services\Upgrades\AddressesPermissions;
use LaravelEnso\Core\Services\Upgrades\AddressLocalization;
use LaravelEnso\Core\Services\Upgrades\ClientInvoices;
use LaravelEnso\Core\Services\Upgrades\ClientPayments;
use LaravelEnso\Core\Services\Upgrades\Companies;
use LaravelEnso\Core\Services\Upgrades\ControlPanel;
use LaravelEnso\Core\Services\Upgrades\People;
use LaravelEnso\Core\Services\Upgrades\Products;
use LaravelEnso\Core\Services\Upgrades\RenameMigrations;
use LaravelEnso\Core\Services\Upgrades\SupplierInvoices;
use LaravelEnso\Core\Services\Upgrades\SupplierPayments;
use LaravelEnso\Core\Services\Upgrades\UserPermissions;
use LaravelEnso\Core\Services\Upgrades\UserResetPasswordPermissions;
use LaravelEnso\Upgrade\Services\Upgrade as Service;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso to the lastest v3.9.x';

    private $upgrades = [
        Addresses::class,
        AddressLocalization::class,
        AddressesPermissions::class,
        Products::class,
        ControlPanel::class,
        UserPermissions::class,
        Companies::class,
        People::class,
        SupplierInvoices::class,
        ClientInvoices::class,
        SupplierPayments::class,
        ClientPayments::class,
        RenameMigrations::class,
        UserResetPasswordPermissions::class,
        PosterMorphKey::class,
    ];

    public function handle()
    {
        (new Service($this->upgrades))->handle();
    }
}
