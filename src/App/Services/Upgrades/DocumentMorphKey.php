<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Documents\App\Models\Document;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class DocumentMorphKey implements MigratesData
{

    private string $namespace = ;

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
            ->update(['attachable_type' => Document::morphMapKey()]);
    }
}
