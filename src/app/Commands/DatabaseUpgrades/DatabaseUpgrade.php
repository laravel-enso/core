<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class DatabaseUpgrade extends Command
{
    protected $title;

    private $time;

    public function __construct()
    {
        parent::__construct();

        $this->output = new ConsoleOutput();
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
        } catch (Exception $exception) {
            $this->rollbackMigrateTable();
            $this->error($this->getUpgradeName().' was unsuccessfully, doing rollback');

            throw  $exception;
        }

        $this->completeMigration();
    }

    public function handle()
    {
        $this->migrate();
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
