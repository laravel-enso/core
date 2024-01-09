<?php

namespace LaravelEnso\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $appName = Config::get('app.name');

        return (new MailMessage())
            ->subject("[ {$appName} ] {$this->title()}")
            ->markdown('laravel-enso/core::emails.reset', [
                'name' => $notifiable->person->name,
                'url'  => url("password/reset/{$this->token}"),
            ]);
    }

    private function title(): string
    {
        return __('Reset password request');
    }
}
