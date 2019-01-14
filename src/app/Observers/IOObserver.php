<?php

namespace LaravelEnso\Core\app\Observers;

use LaravelEnso\Core\app\Enums\IOEvents;
use LaravelEnso\Core\app\Events\IOEvent;
use LaravelEnso\Core\app\Contracts\IOOperation;

class IOObserver
{
    public function created(IOOperation $operation)
    {
        $this->event($operation);
    }

    public function updated(IOOperation $operation)
    {
        $this->event($operation);
    }

    private function event($operation)
    {
        if (IOEvents::has($operation->status())) {
            event(new IOEvent(
                $operation, IOEvents::get($operation->status())
            ));
        }
    }
}
