<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\Upgrades\Addresses;
use LaravelEnso\Core\Upgrades\AddressesPermissions;
use LaravelEnso\Core\Upgrades\AddressLocalization;
use LaravelEnso\Core\Upgrades\ClientInvoices;
use LaravelEnso\Core\Upgrades\ClientPayments;
use LaravelEnso\Core\Upgrades\Companies;
use LaravelEnso\Core\Upgrades\ControlPanel;
use LaravelEnso\Core\Upgrades\ControlPanelApiPermission;
use LaravelEnso\Core\Upgrades\DataImport;
use LaravelEnso\Core\Upgrades\DataImportPermissions;
use LaravelEnso\Core\Upgrades\DeleteUserPermission;
use LaravelEnso\Core\Upgrades\LocalisationPermission;
use LaravelEnso\Core\Upgrades\People;
use LaravelEnso\Core\Upgrades\Postcode;
use LaravelEnso\Core\Upgrades\PostcodeTable;
use LaravelEnso\Core\Upgrades\PosterMorphKey;
use LaravelEnso\Core\Upgrades\Products;
use LaravelEnso\Core\Upgrades\Region;
use LaravelEnso\Core\Upgrades\RenameMigrations;
use LaravelEnso\Core\Upgrades\SupplierInvoices;
use LaravelEnso\Core\Upgrades\SupplierPayments;
use LaravelEnso\Core\Upgrades\UserResetPasswordPermissions;
use LaravelEnso\Core\Upgrades\UserSessionPermissions;
use LaravelEnso\Core\Upgrades\UserTokenPermissions;
use LaravelEnso\Upgrade\Services\Upgrade as Service;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso to the lastest v3.9.x';

    private $upgrades = [
        AddressLocalization::class,
        Products::class,
        ControlPanel::class,
        Companies::class,
        People::class,
        SupplierInvoices::class,
        ClientInvoices::class,
        SupplierPayments::class,
        ClientPayments::class,
        RenameMigrations::class,
        UserResetPasswordPermissions::class,
        PosterMorphKey::class,
        DataImportPermissions::class,
        ControlPanelApiPermission::class,
        UserTokenPermissions::class,
        UserSessionPermissions::class,
        DeleteUserPermission::class,
        AddressesPermissions::class,
        LocalisationPermission::class,
        PostcodeTable::class,
        Postcode::class,
        Addresses::class,
        Region::class,
        DataImport::class,
    ];

    public function handle()
    {
        (new Service($this->upgrades))->handle();
    }
}
