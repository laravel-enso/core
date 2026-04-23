<?php

namespace CoreStateFixtures\FirstPackage\State {
    use LaravelEnso\Core\Contracts\ProvidesState;

    class AppStateProvider implements ProvidesState
    {
        public function store(): string
        {
            return 'app';
        }

        public function state(): array
        {
            return ['first' => true, 'shared' => 'first'];
        }
    }

    class LayoutStateProvider implements ProvidesState
    {
        public function store(): string
        {
            return 'layout';
        }

        public function state(): array
        {
            return ['layoutFlag' => true];
        }
    }

    class IgnoredStateProvider
    {
    }
}

namespace CoreStateFixtures\SecondPackage\State {
    use LaravelEnso\Core\Contracts\ProvidesState;

    class AppStateOverrideProvider implements ProvidesState
    {
        public function store(): string
        {
            return 'app';
        }

        public function state(): array
        {
            return ['second' => true, 'shared' => 'second'];
        }
    }
}

namespace LaravelEnso\Core\Tests {
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\File;
    use LaravelEnso\ActionLogger\Http\Middleware\ActionLogger;
    use LaravelEnso\Core\Services\State\Builder;
    use LaravelEnso\Core\Services\State\Source;
    use LaravelEnso\Impersonate\Http\Middleware\Impersonate;
    use LaravelEnso\Localisation\Http\Middleware\SetLanguage;
    use LaravelEnso\Permissions\Http\Middleware\VerifyRouteAccess;
    use LaravelEnso\Users\Models\User;
    use PHPUnit\Framework\Attributes\Test;
    use Tests\TestCase;

    class CoreStateTest extends TestCase
    {
        use RefreshDatabase;

        private string $fixturesVendor = __DIR__.'/../../../../core-state-fixtures';

        protected function tearDown(): void
        {
            File::deleteDirectory($this->fixturesVendor);

            parent::tearDown();
        }

        #[Test]
        public function source_discovers_only_state_providers(): void
        {
            $package = $this->createPackage(
                'first-package',
                'CoreStateFixtures\\FirstPackage\\',
                ['AppStateProvider', 'LayoutStateProvider', 'IgnoredStateProvider']
            );

            $providers = (new Source($package))->providers()->values()->all();

            $this->assertSame([
                'CoreStateFixtures\\FirstPackage\\State\\AppStateProvider',
                'CoreStateFixtures\\FirstPackage\\State\\LayoutStateProvider',
            ], $providers);
        }

        #[Test]
        public function builder_groups_and_merges_states_by_store(): void
        {
            Config::set('enso.state.vendors', ['core-state-fixtures']);

            $this->createPackage(
                'first-package',
                'CoreStateFixtures\\FirstPackage\\',
                ['AppStateProvider', 'LayoutStateProvider', 'IgnoredStateProvider']
            );
            $this->createPackage(
                'second-package',
                'CoreStateFixtures\\SecondPackage\\',
                ['AppStateOverrideProvider']
            );

            $states = Collection::wrap((new Builder())->handle())
                ->keyBy('store')
                ->map(fn (array $entry) => $entry['state']);

            $this->assertTrue($states->has('app'));
            $this->assertTrue($states->has('layout'));
            $this->assertSame([
                'first'  => true,
                'shared' => 'second',
                'second' => true,
            ], $states->get('app'));
            $this->assertSame(['layoutFlag' => true], $states->get('layout'));
        }

        #[Test]
        public function guest_route_returns_expected_payload_and_auth_routes(): void
        {
            Config::set('app.name', 'Enso Test');
            Config::set('enso.config.extendedDocumentTitle', true);
            Config::set('enso.config.showQuote', false);

            $response = $this->get(route('meta', ['locale' => 'ro']));
            $routes = $response->json('routes');

            $response->assertOk()
                ->assertJsonPath('meta.appName', 'Enso Test')
                ->assertJsonPath('meta.extendedDocumentTitle', true)
                ->assertJsonPath('meta.showQuote', false)
                ->assertJsonPath('routes.login.uri', 'api/login')
                ->assertJsonPath('i18n.ro.Email', __('Email'));

            $this->assertSame('api/password/email', $routes['password.email']['uri']);
            $this->assertSame('api/password/reset', $routes['password.reset']['uri']);
            $this->assertSame('ro', app()->getLocale());
        }

        #[Test]
        public function spa_route_returns_bootstrap_state_for_authenticated_users(): void
        {
            $this->seed();

            $user = User::first();
            $user->update(['is_active' => true]);

            if ($user->preferences === null) {
                $user->initPreferences();
            }

            $response = $this->actingAs($user)
                ->withoutMiddleware([
                    ActionLogger::class,
                    Impersonate::class,
                    SetLanguage::class,
                    VerifyRouteAccess::class,
                ])
                ->get(route('core.home.index'));

            $response->assertOk();

            $stores = Collection::wrap($response->json())->pluck('store');

            $this->assertTrue($stores->contains('app'));
            $this->assertTrue($stores->contains('preferences'));
            $this->assertTrue($stores->contains('layout'));
            $this->assertTrue($stores->contains('websockets'));
        }

        private function createPackage(string $name, string $namespace, array $providers): string
        {
            $package = "{$this->fixturesVendor}/{$name}";

            File::ensureDirectoryExists("{$package}/src/State");

            File::put("{$package}/composer.json", json_encode([
                'autoload' => [
                    'psr-4' => [$namespace => 'src/'],
                ],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            collect($providers)->each(function (string $provider) use ($package) {
                File::put("{$package}/src/State/{$provider}.php", "<?php\n");
            });

            return $package;
        }
    }
}
