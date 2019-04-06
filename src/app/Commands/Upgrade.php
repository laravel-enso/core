<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        // \DB::transaction(function () {
        // });
    }
}
