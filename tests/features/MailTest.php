<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\AppServiceProvider;
use LaravelEnso\Core\MailServiceProvider;
use LaravelEnso\Mails\Preview\PreviewRegistry;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(MailServiceProvider::class);
    }

    #[Test]
    public function registers_owned_mail_previews(): void
    {
        $registry = $this->app->make(PreviewRegistry::class);

        $this->assertSame(
            'laravel-enso/core::emails.reset',
            $registry->get('password-reset')->view()
        );

        $this->assertSame(
            'laravel-enso/core::emails.set',
            $registry->get('password-set')->view()
        );
    }

    public function core_no_longer_publishes_markdown_mail_overrides(): void
    {
        $this->assertSame([], ServiceProvider::pathsToPublish(
            AppServiceProvider::class,
            'core-email'
        ));

        $this->assertSame([], ServiceProvider::pathsToPublish(
            AppServiceProvider::class,
            'enso-email'
        ));
    }
}
