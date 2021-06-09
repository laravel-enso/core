<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\Contracts\ProvidesState;
use LaravelEnso\Core\Services\Inspiring;

class Meta implements ProvidesState
{
    public function mutation(): string
    {
        return 'setMeta';
    }

    public function state(): mixed
    {
        return [
            'appName' => Config::get('app.name'),
            'appUrl' => url('/').'/',
            'version' => Config::get('enso.config.version'),
            'quote' => Inspiring::quote(),
            'env' => App::environment(),
            'dateFormat' => Config::get('enso.config.dateFormat'),
            'dateTimeFormat' => Config::get('enso.config.dateFormat').' H:i:s',
            'extendedDocumentTitle' => Config::get('enso.config.extendedDocumentTitle'),
            'csrfToken' => csrf_token(),
            'sentryDsn' => Config::get('sentry.dsn'),
        ];
    }
}
