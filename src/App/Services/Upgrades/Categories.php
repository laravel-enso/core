<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Menus\App\Models\Menu;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class Categories implements MigratesData
{
    public function isMigrated(): bool
    {
        return Permission::whereName('administration.categories.options')->doesntExist();
    }

    public function migrateData(): void
    {
        Permission::whereName('administration.categories.options')->delete();

        Menu::whereName('Categories')->update(['icon' => 'tags']);
    }
}
