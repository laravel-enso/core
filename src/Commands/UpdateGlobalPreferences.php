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
        $default = $this->defaultGlobal();

        foreach ($this->diff($current) as $key) {
            $current[$key] = $default[$key];
        }

        $value = $preference->value;
        $value['global'] = $current;

        $preference->update(['value' => $value]);
    }

    private function diff($current)
    {
        return Collection::wrap($this->defaultGlobal())->keys()
            ->diff(Collection::wrap($current)->keys());
    }

    private function default()
    {
        return $this->default ??= Preferences::factory()->make();
    }

    private function defaultGlobal(): array
    {
        return data_get($this->default()->value, 'global', []);
    }
}
