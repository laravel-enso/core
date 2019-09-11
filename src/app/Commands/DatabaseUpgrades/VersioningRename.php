<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VersioningRename
{
    private $console;

    public function __construct(Command $console)
    {
        $this->console = $console;
    }

    public function handle()
    {
        $this->console->info('Renaming versionings table');

        DB::table('migrations')->whereMigration('2018_05_01_100000_create_versionings_table')
            ->update(['migration' => '2017_01_01_009000_create_versionings_table']);

        $this->console->info('Versioning table successfully renamed');
    }
}
