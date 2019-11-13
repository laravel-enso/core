<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use LaravelEnso\Core\app\Events\ApplicationUpdated;
use LaravelEnso\Core\app\Models\Preference;

class AnnounceAppUpdate extends Command
{
    protected $signature = 'enso:application:updated';

    protected $description = 'This command will notifies logged in users that the application has been updated';

    public function handle()
    {
        Event::dispatch(new ApplicationUpdated());

        $this->info('Users will be notified.');
    }
}
