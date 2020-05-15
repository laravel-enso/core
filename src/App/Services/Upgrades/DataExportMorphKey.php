<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\DataExport\App\Models\DataExport;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class DataExportMorphKey implements MigratesData
{

    private string $namespace = 'LaravelEnso\\DataExport\\App\\Models\\DataExport';

    public function isMigrated(): bool
    {
        return DB::table('files')->doesntExist()
            || DB::table('files')->where('attachable_type', $this->namespace)
                ->doesntExist();
    }

    public function migrateData(): void
    {
        DB::table('files')
            ->where('attachable_type', $this->namespace)
            ->update(['attachable_type' => DataExport::morphMapKey()]);
    }
}
