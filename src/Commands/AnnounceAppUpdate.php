<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use LaravelEnso\Core\Events\AppUpdate;

class AnnounceAppUpdate extends Command
{
    protected $signature = 'enso:announce-app-update';

    protected $description = 'Notifies logged in users that the application has been updated';

    public function handle()
    {
        Event::dispatch(new AppUpdate());

        $this->info('Users will be notified.');
    }
}
