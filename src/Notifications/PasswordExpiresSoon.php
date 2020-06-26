<?php

namespace LaravelEnso\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PasswordExpiresSoon extends Notification implements ShouldQueue
{
    use Queueable;

    public function via()
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => __('Your password will expire soon').'. '.$this->body($notifiable),
            'path' => '#',
            'icon' => 'cogs',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage([
            'level' => 'warning',
            'title' => __('Your password will expire soon'),
            'body' => $this->body($notifiable),
        ]))->onQueue($this->queue);
    }

    private function body($notifiable)
    {
        $daysLeft = $notifiable->passwordExpiresIn();

        if ($daysLeft > 1) {
            return __("You've got :days days left to change it", [
                'days' => $daysLeft,
            ]);
        }

        if ($daysLeft === 1) {
            return __("You've got until tomorrow to change it");
        }

        return __('You must change it today');
    }
}
