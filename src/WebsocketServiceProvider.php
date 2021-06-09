<?php

namespace LaravelEnso\Core;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\Users\Models\User;

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
            'private' => $this->private(),
        ]);
    }

    private function private(): Closure
    {
        $segments = explode('\\', Config::get('auth.providers.users.model'));

        return fn (User $user) => Collection::wrap([...$segments, $user->id])->implode('.');
    }
}
