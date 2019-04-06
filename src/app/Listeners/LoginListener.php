<?php

namespace LaravelEnso\Core\app\Listeners;

use LaravelEnso\Core\app\Models\Login;
use LaravelEnso\Core\app\Notifications\PasswordExpiresSoonNotification;

class LoginListener
{
    public function handle($event)
    {
        Login::create([
            'user_id' => $event->user->id,
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        if ($event->user->needsPasswordChange()) {
            config('auth.providers.users.model')::find($event->user->id)->notify(
                (new PasswordExpiresSoonNotification())
                    ->onQueue('notifications')
            );
        }
    }
}
