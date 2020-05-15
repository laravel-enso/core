<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class DocumentsMorphKeys implements MigratesData
{
    private array $namespaces = [
        'LaravelEnso\\People\\App\\Models\\Person',
        'LaravelEnso\\Companies\\App\\Models\\Company',
        'LaravelEnso\\Products\\App\\Models\\Product',
    ];

    public function isMigrated(): bool
    {
        return DB::table('documents')->doesntExist()
            || DB::table('documents')->whereIn('documentable_type', $this->namespaces)
                ->doesntExist();
    }

    public function migrateData(): void
    {
        (new Collection($this->namespaces))
            ->reject(fn ($namespace) => ! class_exists($namespace))
            ->each(fn ($namespace) => DB::table('documents')
                ->where('documentable_type', $namespace)
                ->update(['documentable_type' => $namespace::morphMapKey()]));
    }
}
