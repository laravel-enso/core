<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\ActionLogger\Http\Middleware\ActionLogger;
use LaravelEnso\Core\Models\Preferences;
use LaravelEnso\Impersonate\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\Http\Middleware\SetLanguage;
use LaravelEnso\Localisation\Models\Language;
use LaravelEnso\Permissions\Http\Middleware\VerifyRouteAccess;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PreferencesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::first();
        $this->user->update(['is_active' => true]);

        if ($this->user->preferences === null) {
            $this->user->initPreferences();
        }
    }

    #[Test]
    public function preferences_model_updates_values_and_can_reset(): void
    {
        $preferences = $this->user->preferences;
        $language = Language::first();

        $preferences->setGlobal([
            'lang' => 'en',
            'theme' => 'dark',
            'bookmarks' => false,
        ]);
        $preferences->setLocal('products.index', ['filters' => ['active' => true]]);
        $preferences->setTheme('light');
        $preferences->setLanguage($language);

        $preferences->refresh();

        $this->assertSame('light', $preferences->global('theme'));
        $this->assertSame($language->name, $preferences->lang());
        $this->assertSame([
            'filters' => ['active' => true],
        ], $preferences->local('products.index'));

        $preferences->reset();

        $this->assertSame(
            Preferences::factory()->make()->value,
            $preferences->fresh()->value
        );
    }

    #[Test]
    public function preferences_store_endpoint_updates_global_preferences(): void
    {
        $global = [
            'lang' => 'en',
            'dtStateSave' => false,
            'expandedSidebar' => false,
            'bookmarks' => false,
            'theme' => 'dark',
            'toastrPosition' => 'top-left',
        ];

        $this->actingAs($this->user)
            ->withoutMiddleware([
                ActionLogger::class,
                Impersonate::class,
                SetLanguage::class,
                VerifyRouteAccess::class,
            ])
            ->patch(route('core.preferences.store'), ['global' => $global])
            ->assertOk();

        $this->assertSame(
            $global,
            $this->user->preferences->fresh()->global()
        );
    }

    #[Test]
    public function preferences_store_endpoint_updates_local_preferences(): void
    {
        $payload = ['columns' => ['visible' => ['name', 'email']]];

        $this->actingAs($this->user)
            ->withoutMiddleware([
                ActionLogger::class,
                Impersonate::class,
                SetLanguage::class,
                VerifyRouteAccess::class,
            ])
            ->patch(route('core.preferences.store'), [
                'route' => 'users.index',
                'value' => $payload,
            ])
            ->assertOk();

        $this->assertSame(
            $payload,
            $this->user->preferences->fresh()->local('users.index')
        );
    }

    #[Test]
    public function preferences_reset_endpoint_restores_default_preferences(): void
    {
        $this->user->preferences->setLocal('users.index', ['filters' => ['active' => true]]);

        $this->actingAs($this->user)
            ->withoutMiddleware([
                ActionLogger::class,
                Impersonate::class,
                SetLanguage::class,
                VerifyRouteAccess::class,
            ])
            ->post(route('core.preferences.reset'))
            ->assertOk();

        $this->assertSame(
            Preferences::factory()->make()->value,
            $this->user->preferences->fresh()->value
        );
    }
}
