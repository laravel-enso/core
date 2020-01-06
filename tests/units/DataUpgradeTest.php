<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\DatabaseUpgrade;

class DatabaseUpgradeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannot_migrate_when_data_migration_was_not_done()
    {
        $migration = new ExceptionalDataMigrationTest();

        try {
            $migration->migrate();
            $this->assertFalse(true, 'should throw Exception');
        } catch (Exception $e) {
        }

        $this->assertFalse(Schema::hasTable('test'));
    }

    /** @test */
    public function cannot_migrate_when_post_migration_was_not_done()
    {
        $migration = new ExceptionalPostMigrationTest();

        try {
            $migration->migrate();
            $this->assertFalse(true, 'should throw Exception');
        } catch (Exception $e) {
        }

        $this->assertFalse(Schema::hasTable('test'));
    }

    /** @test */
    public function cannot_migrate_when_already_migrated()
    {
        $migration = new MigratedMigrationTest();

        $migration->migrate();

        $this->assertFalse(Schema::hasTable('test'));
    }

    /** @test */
    public function can_upgrade()
    {
        $migration = new TestDatabaseMigration();

        $migration->migrate();

        $this->assertNotEmpty(DB::table('test')->get());
    }


    /** @test */
    public function cannot_migrate_twice()
    {
        $migration = new TestDatabaseMigration();

        $migration->migrate();
        $migration->migrate();

        $this->assertCount(1, DB::table('test')->get());
    }

}

class TestDatabaseMigration extends DatabaseUpgrade
{
    protected function migrateTable()
    {
        Schema::create('test', function ($table) {
            $table->string('name');
        });
    }

    protected function migrateData()
    {
        DB::insert('INSERT INTO test VALUES("test")');
    }

    protected function rollbackMigrateTable()
    {
        Schema::dropIfExists('test');
    }

    protected function isMigrated()
    {
        return Schema::hasTable('test')
            && DB::table('test')->whereName('test')->exists();
    }

    protected function postMigrateTable()
    {
        Schema::table('test', function ($table) {
            $table->string('post_migration')->nullable();
        });
    }


    public function info($string, $verbosity = null)
    {
    }

    public function error($string, $verbosity = null)
    {
    }

}

class ExceptionalDataMigrationTest extends TestDatabaseMigration
{
    protected function migrateData()
    {
        parent::migrateData();

        throw new Exception();
    }
}

class ExceptionalPostMigrationTest extends TestDatabaseMigration
{
    protected function postMigrateTable()
    {
        parent::postMigrateTable();

        throw new Exception();
    }
}

class MigratedMigrationTest extends TestDatabaseMigration
{
    protected function isMigrated()
    {
        return true;
    }
}
