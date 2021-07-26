<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Websockets
{
    private Collection $channels;

    public function __construct()
    {
        $this->channels = new Collection();
    }

    public function register($channels): void
    {
        Collection::wrap($channels)
            ->each(fn ($channel, $key) => $this->channels
                ->put($key, $channel));
    }

    public function remove($aliases): void
    {
        Collection::wrap($aliases)
            ->each(fn ($alias) => $this->channels->forget($alias));
    }

    public function all()
    {
        return $this->channels->map(fn ($channel) => is_string($channel)
            ? $channel
            : $channel->call($this, Auth::user()));
    }
}
