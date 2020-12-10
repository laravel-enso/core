<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\Contracts\BeforeMigration;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class RenameJobBatchesMigration implements MigratesData, BeforeMigration
{
    private const Old = '2020_11_27_129000_create_job_batches_table';
    private const New = '2017_01_01_002500_create_job_batches_table';

    public function isMigrated(): bool
    {
        return $this->oldMigration()->doesntExist();
    }

    public function migrateData(): void
    {
        $this->oldMigration()->update(['migration' => self::New]);
    }

    private function oldMigration()
    {
        return DB::table('migrations')->whereMigration(self::Old);
    }
}
