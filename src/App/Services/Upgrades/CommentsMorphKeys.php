<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class CommentsMorphKeys implements MigratesData
{
    private array $models = [
        'LaravelEnso\\Companies\\App\\Models\\Company',
        'LaravelEnso\\Products\\App\\Models\\Product',
    ];

    public function isMigrated(): bool
    {
        return DB::table('comments')->doesntExist()
            || DB::table('comments')->whereIn('commentable_type', $this->models)
            ->doesntExist();
    }

    public function migrateData(): void
    {
        (new Collection($this->models))
            ->filter(fn ($model) => class_exists($model))
            ->each(fn ($namespace) => DB::table('comments')
                ->where('commentable_type', $namespace)
                ->update(['commentable_type' => $namespace::morphMapKey()]));
    }
}
