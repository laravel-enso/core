<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Version
{
    private const Endpoint = 'https://api.github.com/repos/laravel-enso/enso/releases/latest';

    private string $release;

    public function latest(): string
    {
        return $this->release
            ??= Http::get(self::Endpoint)->throw()->json('tag_name');
    }

    public function current(): string
    {
        return Config::get('enso.config.version');
    }

    public function isOutdated(): bool
    {
        return $this->current() !== $this->latest();
    }
}
