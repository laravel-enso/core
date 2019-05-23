<?php

namespace LaravelEnso\Core\app\Listeners;

use Carbon\Carbon;

class PasswordResetListener
{
    public function handle($event)
    {
        if ((int) config('enso.auth.password.lifetime') > 0) {
            $event->user->password_updated_at = Carbon::now();
            $event->user->save();
        }
    }
}
