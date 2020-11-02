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

    public function register($channels)
    {
        (new Collection($channels))->each(fn ($channel, $key) => $this->channels->put(
            $key,
            $channel
        ));
    }

    public function remove($aliases)
    {
        (new Collection($aliases))->each(fn ($alias) => $this->channels->forget($alias));
    }

    public function all()
    {
        return $this->channels
            ->filter(fn ($channel) => is_string($channel) || $channel instanceof \Closure)
            ->map(fn ($channel) => is_string($channel) ? $channel : $channel->call($this, Auth::user()));
    }
}
