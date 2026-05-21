<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Markdown;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\AppServiceProvider;
use LaravelEnso\Mails\Preview\PreviewRegistry;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registers_owned_mail_previews(): void
    {
        $registry = $this->app->make(PreviewRegistry::class);

        $this->assertSame(
            'laravel-enso/core::emails.reset',
            $registry->get('password-reset')->view()
        );

        $this->assertSame(
            'laravel-enso/core::emails.reset',
            $registry->get('password-set')->view()
        );
    }

    #[Test]
    public function reset_password_mail_renders_with_shared_mail_components(): void
    {
        $html = $this->app->make(Markdown::class)->render('laravel-enso/core::emails.reset', [
            'name' => 'Jane',
            'url' => 'https://example.com/password/reset/token',
        ])->toHtml();

        $this->assertStringContainsString('Jane', $html);
        $this->assertStringContainsString('https://example.com/password/reset/token', $html);
        $this->assertStringContainsString('<a href="https://example.com/password/reset/token"', $html);
        $this->assertStringContainsString('Echipa', $html);
    }

    #[Test]
    public function set_password_preview_renders_the_owned_variant(): void
    {
        $preview = $this->app->make(PreviewRegistry::class)->get('password-set');

        $html = $this->app->make(Markdown::class)
            ->render($preview->view(), $preview->data())
            ->toHtml();

        $this->assertStringContainsString('Set your password', $html);
        $this->assertStringContainsString('This link can be used only once', $html);
        $this->assertStringContainsString('https://example.com/password/set/token', $html);
        $this->assertStringContainsString('<a href="https://example.com/password/set/token"', $html);
    }

    #[Test]
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
