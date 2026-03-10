<?php

namespace LaravelEnso\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\Models\Preferences;

class UpdateGlobalPreferences extends Command
{
    protected $signature = 'enso:preferences:update-global';

    protected $description = 'Adds new global preferences keys for users';

    private Preferences $default;

    public function handle()
    {
        DB::transaction(function () {
            Preferences::each(fn ($preference) => $this->update($preference));
        });

        $this->info('Preferences were successfully updated.');
    }

    private function update($preference)
    {
        $current = $preference->global();

        $this->diff($current)
            ->each(fn ($key) => $current[$key] = $this->default()->global($key));

        $preference->value['global'] = $current;

        $preference->update(['value' => $preference->value]);
    }

    private function diff($current)
    {
        $global = $this->default->global();

        return Collection::wrap($global)->keys()
            ->diff(Collection::wrap($current)->keys());
    }

    private function default()
    {
        return $this->default ??= Preferences::factory()->make();
    }
}
