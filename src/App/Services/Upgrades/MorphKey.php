<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class MorphKey implements MigratesData
{

    private array $namespaces = [
        'LaravelEnso\\Documents\\App\\Models\\Document',
        'LaravelEnso\\DataImport\\App\\Models\\DataImport',
        'LaravelEnso\\DataImport\\App\\Models\\ImportTemplate',
        'LaravelEnso\\DataImport\\App\\Models\\RejectedImport',
        'LaravelEnso\\Files\\App\\Models\\Upload',
        'LaravelEnso\\HowTo\\App\\Models\\Video',
    ];

    public function isMigrated(): bool
    {
        return DB::table('files')->doesntExist()
            || DB::table('files')->whereIn('attachable_type', $this->namespaces)
                ->doesntExist();
    }

    public function migrateData(): void
    {
        (new Collection($this->namespaces))
            ->each(fn($namespace) => DB::table('files')
                ->where('attachable_type', $namespace)
                ->update(['attachable_type' => $namespace::morphMapKey()]));
    }
}
