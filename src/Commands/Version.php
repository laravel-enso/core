<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\Services\Version as Service;

class Version extends Command
{
    protected $signature = 'enso:version';

    protected $description = 'Display framework version';

    public function handle()
    {
        $version = (new Service());
        $this->info("Current version is {$version->current()}");

        if ($version->isOutdated()) {
            $this->warn("Latest version is {$version->latest()}");
        }
    }
}
