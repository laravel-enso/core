<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Core\App\Commands\DatabaseUpgrades\StructureUpgrade;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Models\Role;
use Tests\TestCase;

class StructureUpgradeTest extends TestCase
{
    use RefreshDatabase;
    protected $migration;
    protected $defaultRole;
    protected $nonDefaultRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migration = new TestStructureMigration();

        $this->defaultRole = $this->createTestRole(config('enso.config.defaultRole'));

        $this->nonDefaultRole = $this->createTestRole('nonDefaultRole');
    }

    /** @test */
    public function cannot_migrate_when_permission_already_exists()
    {
        $this->migration->permissions = [
            ['name' => 'test', 'description' => 'test', 'type' => 0, 'is_default' => true],
        ];

        $this->migration->migrate();
        $this->migration->migrate();

        $this->assertEquals(1, Permission::whereName('test')->count());
    }

    /** @test */
    public function can_migrate_default_permission()
    {
        $this->migration->permissions = [
            ['name' => 'test', 'description' => 'test', 'type' => 0, 'is_default' => true],
        ];

        $this->migration->migrate();

        $this->assertEquals('test', $this->defaultRole->permissions[0]->name);
        $this->assertEquals('test', $this->nonDefaultRole->permissions[0]->name);
    }

    /** @test */
    public function can_migrate_non_default_permission()
    {
        $this->migration->permissions = [
            ['name' => 'test', 'description' => 'test', 'type' => 0, 'is_default' => false],
        ];

        $this->migration->migrate();

        $this->assertEquals('test', $this->defaultRole->permissions[0]->name);
        $this->assertEmpty($this->nonDefaultRole->permissions);
    }

    /** @test */
    public function can_migrate()
    {
        $this->migration->permissions = [
            ['name' => 'test', 'description' => 'test', 'type' => 0, 'is_default' => true],
        ];

        $this->migration->migrate();

        $this->assertTrue(Permission::whereName('test')->exists());
    }

    protected function createTestRole($name)
    {
        return factory(Role::class)->create([
            'name' => $name,
        ]);
    }
}

class TestStructureMigration extends StructureUpgrade
{
    public $permissions = [];

    public function info($string, $verbosity = null)
    {
    }

    public function error($string, $verbosity = null)
    {
    }
}
