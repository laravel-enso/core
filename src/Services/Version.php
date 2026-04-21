<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Version
{
    private const Endpoint = 'https://api.github.com/repos/laravel-enso/enso/releases/latest';

    private string $release;

    public function latest(): string
    {
        return $this->release
            ??= $this->request()->get(self::Endpoint)->throw()->json('tag_name');
    }

    public function current(): string
    {
        return Config::get('enso.config.version');
    }

    public function isOutdated(): bool
    {
        return $this->current() !== $this->latest();
    }

    private function request(): PendingRequest
    {
        $request = Http::acceptJson();

        if ($token = Config::get('enso.config.githubToken')) {
            $request = $request->withToken($token);
        }

        return $request;
    }
}
