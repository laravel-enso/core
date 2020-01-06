<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\App\Models\Preference;

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
