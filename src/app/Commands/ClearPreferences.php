<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\app\Models\Preference;

class ClearPreferences extends Command
{
    protected $signature = 'enso:preferences:clear';

    protected $description = 'This command will clear enso preferences';

    public function handle()
    {
        Preference::truncate();

        $this->info('Preferences were successfully cleared.');
    }
}
