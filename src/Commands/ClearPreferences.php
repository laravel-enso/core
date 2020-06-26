<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\Models\Preference;

class ClearPreferences extends Command
{
    protected $signature = 'enso:preferences:clear';

    protected $description = 'Clears user preferences';

    public function handle()
    {
        Preference::truncate();

        $this->info('Preferences were successfully cleared.');
    }
}
