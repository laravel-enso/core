<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use LaravelEnso\Core\Rules\DistinctPassword;
use LaravelEnso\Core\Services\Inspiring;
use LaravelEnso\Core\Services\Version;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CoreUtilitiesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function version_service_and_command_report_current_and_latest_versions(): void
    {
        Config::set('enso.config.version', '1.0.0');
        Config::set('enso.config.githubToken', 'github-token');

        Http::fake([
            'api.github.com/repos/laravel-enso/enso/releases/latest' => Http::response([
                'tag_name' => '1.1.0',
            ]),
        ]);

        $service = new Version();

        $this->assertSame('1.0.0', $service->current());
        $this->assertSame('1.1.0', $service->latest());
        $this->assertTrue($service->isOutdated());

        Http::assertSent(fn ($request) => $request->url() === 'https://api.github.com/repos/laravel-enso/enso/releases/latest'
            && $request->hasHeader('Authorization', 'Bearer github-token'));

        $this->artisan('enso:version')
            ->expectsOutput('Current version is 1.0.0')
            ->expectsOutput('Latest version is 1.1.0')
            ->assertSuccessful();
    }

    #[Test]
    public function distinct_password_rule_rejects_current_password_and_accepts_empty_or_new_ones(): void
    {
        $this->seed();

        $user = User::first();
        $user->password = 'password';
        $user->save();
        $user->refresh();
        $rule = new DistinctPassword($user);

        $this->assertFalse($rule->passes('password', 'password'));
        $this->assertTrue($rule->passes('password', 'new-password'));
        $this->assertTrue($rule->passes('password', null));
        $this->assertSame(
            __('You cannot use the existing password'),
            $rule->message()
        );
    }

    #[Test]
    public function inspiring_service_returns_only_configured_quotes(): void
    {
        Config::set('enso.inspiring.quotes', [
            'First quote',
            'Second quote',
        ]);

        $this->assertContains(
            Inspiring::quote(),
            Config::get('enso.inspiring.quotes')
        );
    }
}
