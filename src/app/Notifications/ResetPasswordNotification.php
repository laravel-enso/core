<?php

namespace LaravelEnso\Core\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        app()->setLocale($notifiable->preferences->global->lang);

        return (new MailMessage())
            ->subject(__('Reset Password Notification'))
            ->view('laravel-enso/core::emails.passwordReset',
                [
                    'body'        => __('Please set or reset your password by clicking the button below.'),
                    'ending'      => __('Thank you for using our application'),
                    'resetURL'    => config('app.url') . '/password/reset/' . $this->token,
                    'buttonLabel' => __('Reset Your Password'),
                ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
