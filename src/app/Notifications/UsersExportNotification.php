<?php

namespace LaravelEnso\Core\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsersExportNotification extends Notification
{
    use Queueable;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line(__('You will find attached the requested report.'))
            ->line(__('Thank you for using our application!'))
            ->attach($this->file);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
