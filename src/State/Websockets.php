<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\Contracts\ProvidesState;
use LaravelEnso\Core\Facades\Websockets as Facade;

class Websockets implements ProvidesState
{
    public function mutation(): string
    {
        return 'websockets/configure';
    }

    public function state(): mixed
    {
        return [
            'pusher' => [
                'key' => Config::get('broadcasting.connections.pusher.key'),
                'options' => Config::get('broadcasting.connections.pusher.options'),
            ],
            'channels' => Facade::all(),
        ];
    }
}
