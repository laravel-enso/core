<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\DataImport\App\Models\RejectedImport;
use LaravelEnso\Files\App\Models\File;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class DataImportCleanup implements MigratesData
{
    public function isMigrated(): bool
    {
        return File::where('attachable_type', 'rejectedImport')
            ->doesntHaveMorph('attachable', [RejectedImport::class])
            ->doesntExist();
    }

    public function migrateData(): void
    {
        File::where('attachable_type', 'rejectedImport')
            ->doesntHaveMorph('attachable', [RejectedImport::class])
            ->get()
            ->each->delete();
    }
}
