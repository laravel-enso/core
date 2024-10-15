<?php

namespace LaravelEnso\Core\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use LaravelEnso\Core\Notifications\ResetPassword;

trait HasPassword
{
    public function currentPasswordIs(string $password)
    {
        return $this->password && Hash::check($password, $this->password);
    }

    public function passwordExpired()
    {
        $lifetime = (int) config('enso.auth.password.lifetime');

        return $lifetime > 0 && ($this->password_updated_at === null
            || ((int) now()->diffInDays($this->password_updated_at, true)) > $lifetime);
    }

    public function needsPasswordChange()
    {
        return (int) config('enso.auth.password.lifetime') > 0
            && $this->password_updated_at !== null
            && $this->passwordExpiresIn() <= 3;
    }

    public function passwordExpiresIn()
    {
        return $this->password_updated_at
            ->addDays((int) config('enso.auth.password.lifetime'))
            ->diffInDays(Carbon::now(), true);
    }

    public function sendResetPasswordEmail()
    {
        $this->sendPasswordResetNotification(
            app('auth.password.broker')
                ->createToken($this)
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify((new ResetPassword($token))
            ->onQueue('notifications'));
    }
}
