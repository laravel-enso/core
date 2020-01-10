<?php

namespace LaravelEnso\Core\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $title;
    public string $message;
    public string $tooltip;

    public $queue;

    private string $name;

    public function __construct()
    {
        $this->name = 'new-update';
        $this->queue = 'notifications';

        $this->title = 'Important';
        $this->message = 'The application was updated, please save your work & refresh your browser';
        $this->tooltip = 'Save your work then click here to refresh your page and update to the latest application version';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('app-updates');
    }

    public function broadcastAs()
    {
        return $this->name;
    }
}
