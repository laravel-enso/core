<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\HowTo\Models\Poster;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class PosterMorphKey implements MigratesData
{
    public function isMigrated(): bool
    {
        return DB::table('files')
            ->whereAttachableType(Poster::morphMapKey())
            ->exists();
    }

    public function migrateData(): void
    {
        DB::table('files')
            ->where('attachable_type', 'LaravelEnso\\\HowTo\\\App\\\Models\\\Poster')
            ->update(['attachable_type' => Poster::morphMapKey()]);
    }
}
