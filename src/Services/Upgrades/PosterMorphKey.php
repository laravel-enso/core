<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\HowTo\Models\Poster;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class PosterMorphKey implements MigratesData
{
    public function isMigrated(): bool
    {
        return ! class_exists(Poster::class) || DB::table('files')
            ->where('attachable_type', 'LaravelEnso\\HowTo\\App\\Models\\Poster')
            ->orWhere('attachable_type', 'LaravelEnso\\HowTo\\Models\\Poster')
            ->doesntExist();
    }

    public function migrateData(): void
    {
        DB::table('files')
            ->where('attachable_type', 'LaravelEnso\\HowTo\\App\\Models\\Poster')
            ->orWhere('attachable_type', 'LaravelEnso\\HowTo\\Models\\Poster')
            ->update(['attachable_type' => Poster::morphMapKey()]);
    }
}
