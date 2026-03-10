<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use LaravelEnso\Core\Models\Preferences;
use LaravelEnso\Users\Models\User;

class ResetPreferences extends Command
{
    protected $signature = 'enso:preferences:reset';

    protected $description = 'Reset user preferences';

    public function handle()
    {
        Preferences::truncate();

        User::eachById(fn ($user) => $user->initPreferences());

        $this->info('Preferences were successfully reset.');
    }
}
