<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\Events\AppUpdate;

class AnnounceAppUpdate extends Command
{
    protected $signature = 'enso:announce-app-update';

    protected $description = 'Notifies logged in users that the application has been updated';

    public function handle()
    {
        AppUpdate::dispatch();

        $this->info('Users will be notified.');
    }
}
