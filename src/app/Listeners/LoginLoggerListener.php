<?php

namespace LaravelEnso\Core\app\Listeners;

use LaravelEnso\Core\app\Models\Login;

class LoginLoggerListener
{
    public function handle($event)
    {
        Login::create([
            'user_id' => $event->user->id,
            'ip' => request()->ip(),
            'user_agent' => request()
                ->header('User-Agent'),
        ]);
    }
}
