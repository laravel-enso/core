<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Mails\Preview\PreviewDefinition;
use LaravelEnso\Mails\Preview\PreviewRegistry;

class MailServiceProvider extends ServiceProvider
{
    public function boot(PreviewRegistry $registry): void
    {
        $registry->register(new PreviewDefinition(
            key: 'password-reset',
            name: 'Password Reset',
            view: 'laravel-enso/core::emails.reset',
            data: [
                'name' => 'Jane',
                'url' => 'https://example.com/password/reset/token',
            ],
            section: PreviewDefinition::Core,
        ));

        $registry->register(new PreviewDefinition(
            key: 'password-set',
            name: 'Password Set',
            view: 'laravel-enso/core::emails.set',
            data: [
                'name' => 'Jane',
                'url' => 'https://example.com/password/reset/token',
            ],
            section: PreviewDefinition::Core,
        ));
    }
}
