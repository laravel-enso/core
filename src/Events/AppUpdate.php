<?php

namespace LaravelEnso\Core\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;

    public $queue;

    public function __construct()
    {
        $this->queue = 'notifications';

        $this->message = 'The application was updated, please refresh your page to load the latest application version';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('app-updates');
    }

    public function broadcastAs()
    {
        return 'app-update';
    }
}
