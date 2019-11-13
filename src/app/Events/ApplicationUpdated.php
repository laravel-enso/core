<?php

namespace LaravelEnso\Core\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $name;

    public $message;

    public function __construct()
    {
        $this->name = 'updated';
        $this->queue = 'notifications';

        $this->message = 'The application was updated, please refresh your browser';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('application-updates');
    }

    public function broadcastAs()
    {
        return $this->name;
    }
}
