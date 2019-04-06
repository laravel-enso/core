<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use LaravelEnso\Core\app\Models\Preference;
use LaravelEnso\Core\app\Classes\DefaultPreferences;

class UpdateGlobalPreferences extends Command
{
    protected $signature = 'enso:preferences:update-global';

    protected $description = 'This command will add new global preferences keys for users';

    private $defaultPreferences;

    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'core-preferences',
            '--force' => true,
        ]);

        $this->defaultPreferences = $this->defaultPreferences();

        \DB::transaction(function () {
            Preference::chunk(1000, function ($preferences) {
                $preferences->each(function ($preference) {
                    $meta = $preference->value;

                    $this->diff($meta)->each(function ($key) use ($meta) {
                        $meta->global->{$key} = $this->defaultPreferences->global->{$key};
                    });

                    $preference->update(['value' => $meta]);
                });
            });
        });

        $this->info('Preferences were successfully updated.');
    }

    private function diff($meta)
    {
        return collect($this->defaultPreferences->global)
            ->keys()
            ->diff(
                collect($meta->global)->keys()
            );
    }

    private function defaultPreferences()
    {
        return DefaultPreferences::data();
    }
}
