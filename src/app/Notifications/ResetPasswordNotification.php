<?php

namespace LaravelEnso\Core\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $user;

    public function __construct($user, $token)
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('Reset Password Notification'))
            ->view('laravel-enso/core::emails.passwordReset',
                [
                    'line1'          => __('Please set or reset your password by clicking the button below.'),
                    'line2'          => __('Thank you for using our application!'),
                    'resetURL'          => config('app.url').'/password/reset/'.$this->token,
                ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
