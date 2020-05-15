<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Inventory\App\Models\Warehouse;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class AddressesMorphKeys implements MigratesData
{

    private array $namespaces = [
        'LaravelEnso\\Companies\\App\\Models\\Company',
        'LaravelEnso\\People\\App\\Models\\Person',
        'LaravelEnso\\Inventory\\App\\Models\\Warehouse',
    ];

    public function isMigrated(): bool
    {
        return DB::table('addresses')->doesntExist()
            || DB::table('addresses')->whereIn('addressable_type', $this->namespaces)
                ->doesntExist();
    }

    public function migrateData(): void
    {
        (new Collection($this->namespaces))
            ->reject(fn($namespace) => ! class_exists($namespace))
            ->each(fn($namespace) => DB::table('addresses')
                ->where('addressable_type', $namespace)
                ->update(['addressable_type' => $namespace::morphMapKey()]));
    }
}
