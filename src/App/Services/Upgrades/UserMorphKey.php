<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class UserMorphKey implements MigratesData
{
    public function isMigrated(): bool
    {
        return DB::table('notifications')->doesntExist()
            || DB::table('notifications')
            ->whereNotifiableType(User::morphMapKey())->exists();
    }

    public function migrateData(): void
    {
        DB::table('notifications')
            ->where('notifiable_type', 'like', '%App\\\\Models\\\\User')
            ->orWhere('notifiable_type', 'like', '%App\\\\User')
            ->update(['notifiable_type' => User::morphMapKey()]);
    }
}
