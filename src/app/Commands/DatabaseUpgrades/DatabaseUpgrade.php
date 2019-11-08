<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class DatabaseUpgrade extends Command
{
    private $time;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    abstract protected function isMigrated();

    protected function migrateTable()
    {
    }

    protected function migrateData()
    {
    }

    protected function postMigrateTable()
    {
    }

    protected function rollbackMigrateTable()
    {
    }

    public function getUpgradeName()
    {
        if ($this->title) {
            return $this->title;
        }

        $className = (new ReflectionClass($this))->getShortName();

        return Str::snake($className);
    }

    public function migrate()
    {
        if ($this->isMigrated()) {
            $this->info($this->getUpgradeName().' has been already done');

            return;
        }

        $this->startMigration();

        $this->migrateTable();

        try {
            DB::transaction(function () {
                $this->migrateData();
            });

            $this->postMigrateTable();
        } catch (Exception $e) {
            $this->rollbackMigrateTable();
            $this->error($this->getUpgradeName().' was unsuccessfully, doing rollback');

            throw  $e;
        }

        $this->completeMigration();
    }

    public function handle()
    {
        $this->migrate();
    }

    private function startMigration()
    {
        $this->time = microtime(true);
        $this->info($this->getUpgradeName().' is starting');
    }

    private function completeMigration()
    {
        $time = (int) ((microtime(true) - $this->time) * 1000);
        $this->info($this->getUpgradeName().' was done ('.$time.' ms)');
    }
}
