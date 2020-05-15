<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class DiscussionsMorphKeys implements MigratesData
{

    private array $namespaces = [
        'LaravelEnso\\Companies\\App\\Models\\Company',
        'LaravelEnso\\People\\App\\Models\\Person',
    ];

    public function isMigrated(): bool
    {
        return DB::table('discussions')->doesntExist()
            || DB::table('discussions')->whereIn('discussable_type', $this->namespaces)
                ->doesntExist();
    }

    public function migrateData(): void
    {
        (new Collection($this->namespaces))
            ->each(fn($namespace) => DB::table('discussions')
                ->where('discussable_type', $namespace)
                ->update(['discussable_type' => $namespace::morphMapKey()]));
    }
}
