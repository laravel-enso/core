<?php

namespace LaravelEnso\Core;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\Core\Models\User;

class WebsocketServiceProvider extends ServiceProvider
{
    protected array $register = [];

    public function boot()
    {
        return static::class === self::class
            ? $this->coreChannels()
            : Websockets::register($this->register);
    }

    private function coreChannels()
    {
        Websockets::register([
            'appUpdates' => 'app-updates',
            'private' => fn (User $user) => (new Collection(
                explode('\\', Config::get('auth.providers.users.model'))
            ))->push($user->id)->implode('.'),
        ]);
    }
}
