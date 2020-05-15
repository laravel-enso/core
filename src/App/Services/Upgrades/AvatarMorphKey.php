<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Avatars\App\Models\Avatar;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class AvatarMorphKey implements MigratesData
{

    private string $namespace = 'LaravelEnso\\Avatars\\App\\Models\\Avatar';

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
            ->update(['attachable_type' => Avatar::morphMapKey()]);
    }
}
