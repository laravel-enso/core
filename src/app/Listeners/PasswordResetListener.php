<?php

namespace LaravelEnso\Core\app\Listeners;

class PasswordResetListener
{
    public function handle($event)
    {
        $event->user->password_updated_at = now();
        $event->user->save();
    }
}
