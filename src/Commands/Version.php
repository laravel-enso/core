<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use LaravelEnso\Core\Events\AppUpdate;
use LaravelEnso\Core\Services\Version as Service;

class Version extends Command
{
    protected $signature = 'enso:version';

    protected $description = 'Update version to the lastest version';

    public function handle()
    {
        $version = (new Service());
        $this->info("Current version is {$version->current()}");
        $this->info("Latest version is {$version->latest()}");

        if ($version->isOutdated() && $this->confirm("Your application version is outdated, Do you want to update to the latest?")) {
            $version->update();

            $this->info("Your version is {$version->latest()} now");
        }
    }
}
