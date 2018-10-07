<?php

namespace LaravelEnso\Core\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->lang());

        return (new MailMessage())
            ->subject(__(config('app.name')).': '.__('Reset Password Notification'))
            ->markdown('laravel-enso/core::emails.reset', [
                'name' => $notifiable->person->name,
                'url' => url('password/reset/'.$this->token),
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
