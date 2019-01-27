<?php

namespace LaravelEnso\Core\app\Listeners;

class PasswordResetListener
{
    public function handle($event)
    {
        if ((int) config('enso.auth.password.lifetime') > 0) {
            $event->user->password_updated_at = now();
            $event->user->save();
        }
    }
}
