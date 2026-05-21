<?php

namespace LaravelEnso\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class SetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $token)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $appName = Config::get('app.name');

        return (new MailMessage())
            ->subject("[ {$appName} ] {$this->title()}")
            ->markdown('laravel-enso/core::emails.set', [
                'name' => $notifiable->person->name,
                'url'  => URL::to("password/reset/{$this->token}"),
            ]);
    }

    private function title(): string
    {
        return __('Set your password');
    }
}
