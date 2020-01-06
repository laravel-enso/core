<?php

namespace LaravelEnso\Core\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\App\Models\Preference;
use LaravelEnso\Core\App\Services\DefaultPreferences;

class UpdateGlobalPreferences extends Command
{
    protected $signature = 'enso:preferences:update-global';

    protected $description = 'Adds new global preferences keys for users';

    private $default;

    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'core-preferences',
            '--force' => true,
        ]);

        DB::transaction(function () {
            Preference::each(fn ($preference) => $this->update($preference));
        });

        $this->info('Preferences were successfully updated.');
    }

    private function update($preference)
    {
        $meta = $preference->value;

        $this->diff($meta)
            ->each(fn ($key) => $meta->global->{$key} = $this->default()->global->{$key});

        $preference->update(['value' => $meta]);
    }

    private function diff($meta)
    {
        return (new Collection($this->default()->global))->keys()
            ->diff((new Collection($meta->global))->keys());
    }

    private function default()
    {
        return $this->default ??= DefaultPreferences::data();
    }
}
