<?php

namespace LaravelEnso\Core\App\Listeners;

use LaravelEnso\Core\App\Events\Login as Event;
use LaravelEnso\Core\App\Models\Login;
use LaravelEnso\Core\App\Notifications\PasswordExpiresSoon;

class LoginListener
{
    public function handle(Event $event)
    {
        Login::create([
            'user_id' => $event->user()->id,
            'ip' => $event->ip(),
            'user_agent' => $event->userAgent(),
        ]);

        if ($event->user()->needsPasswordChange()) {
            $event->user()->notify(
                (new PasswordExpiresSoon())->onQueue('notifications')
            );
        }
    }
}
