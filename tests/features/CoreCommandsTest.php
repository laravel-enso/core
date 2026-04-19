<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use LaravelEnso\Core\Events\AppUpdate;
use LaravelEnso\Core\Models\Preferences;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CoreCommandsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        User::each(function (User $user) {
            if ($user->preferences === null) {
                $user->initPreferences();
            }
        });
    }

    #[Test]
    public function announce_app_update_dispatches_the_event(): void
    {
        Event::fake([AppUpdate::class]);

        $this->artisan('enso:announce-app-update')
            ->expectsOutput('Users will be notified.')
            ->assertSuccessful();

        Event::assertDispatched(AppUpdate::class);
    }

    #[Test]
    public function reset_preferences_recreates_default_preferences_for_all_users(): void
    {
        Preferences::query()->update([
            'value' => [
                'global' => ['theme' => 'dark'],
                'local'  => ['users.index' => ['collapsed' => true]],
            ],
        ]);

        $this->artisan('enso:preferences:reset')
            ->expectsOutput('Preferences were successfully reset.')
            ->assertSuccessful();

        $this->assertSame(User::count(), Preferences::count());

        Preferences::each(function (Preferences $preferences) {
            $this->assertSame(
                Preferences::factory()->make()->value,
                $preferences->value
            );
        });
    }

    #[Test]
    public function update_global_preferences_adds_missing_global_keys(): void
    {
        $preferences = Preferences::first();
        $value = $preferences->value;
        unset($value['global']['theme']);
        $preferences->update(['value' => $value]);

        $this->artisan('enso:preferences:update-global')
            ->expectsOutput('Preferences were successfully updated.')
            ->assertSuccessful();

        $this->assertSame(
            'light',
            $preferences->fresh()->global('theme')
        );
    }

    #[Test]
    public function reset_storage_clears_default_and_included_directories(): void
    {
        Storage::fake();

        Storage::put('avatars/one.txt', 'avatar');
        Storage::put('exports/two.txt', 'export');
        Storage::put('testing/three.txt', 'temp');
        Storage::put('custom/four.txt', 'custom');

        $this->artisan('enso:storage:reset', ['--include' => 'custom'])
            ->assertSuccessful();

        $this->assertSame([], Storage::files('avatars'));
        $this->assertSame([], Storage::files('exports'));
        $this->assertSame([], Storage::files('custom'));
        $this->assertFalse(in_array('testing', Storage::directories()));
        $this->assertTrue(in_array('files', Storage::directories()));
        $this->assertTrue(in_array('imports', Storage::directories()));
    }
}
