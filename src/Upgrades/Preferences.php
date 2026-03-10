<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Support\Facades\File;
use LaravelEnso\Upgrade\Contracts\MigratesData;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Users\Models\User;

class Preferences implements MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return User::doesntHave('preferences')->doesntExist();
    }

    public function migrateData(): void
    {
        User::doesntHave('preferences')
            ->eachById(fn (User $user) => $user->initPreferences());
    }

    public function migratePostDataMigration(): void
    {
        File::delete(resource_path('preferences.json'));
    }
}
