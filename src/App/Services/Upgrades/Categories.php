<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Categories implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return ! class_exists(Category::class)
            || Schema::hasColumn('categories', 'order_index');
    }

    public function migrateTable(): void
    {
        Schema::table('categories', fn ($table) => $table
            ->unsignedInteger('order_index')->nullable()->after('name'));
    }

    public function migrateData(): void
    {
        $this->updateCategories(Category::topLevel()->get());
    }

    public function migratePostDataMigration(): void
    {
        Schema::table('categories', fn ($table) => $table
            ->unsignedInteger('order_index')->nullable(false)->change());

        Permission::whereName('administration.categories.create')
            ->update(['name' => 'administration.categories.move']);

        Permission::whereIn('name', [
            'administration.categories.edit', 'administration.categories.initTable',
            'administration.categories.tableData', 'administration.categories.exportExcel',
        ])->delete();
    }

    private function updateCategories(Collection $categories)
    {
        $categories->each(fn ($category, $index) => $this->updateCategory($category, $index));
    }

    private function updateCategory(Category $category, int $index)
    {
        $category->update(['order_index' => $index + 1]);

        $this->updateCategories(Category::whereParentId($category->id)->get());
    }
}
