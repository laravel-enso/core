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
            $event->user->notify(
                (new PasswordExpiresSoonNotification())
                    ->onQueue('notifications')
            );
        }
    }
}
