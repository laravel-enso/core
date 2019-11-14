<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use LaravelEnso\Core\app\Events\AppUpdated;

class AnnounceAppUpdate extends Command
{
    protected $signature = 'enso:announce-app-update';

    protected $description = 'This command notifies logged in users that the application has been updated';

    public function handle()
    {
        Event::dispatch(new AppUpdated());

        $this->info('Users will be notified.');
    }
}
