<?php

namespace LaravelEnso\Core\Services\State;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Builder
{
    public function handle(): array
    {
        return $this->sources()
            ->map(fn ($source) => $this->state($source))
            ->filter->isNotEmpty()
            ->collapse()
            ->groupBy('store')
            ->map(fn ($states, $store) => [
                'store' => $store,
                'state' => $states
                    ->pluck('state')
                    ->reduce(
                        fn ($merged, $state) => array_merge($merged, $state),
                        []
                    ),
            ])
            ->values()
            ->toArray();
    }

    private function sources(): Collection
    {
        return Collection::wrap(Config::get('enso.state.vendors'))
            ->map(fn ($vendor) => base_path('vendor'.DIRECTORY_SEPARATOR.$vendor))
            ->map(fn ($vendor) => File::directories($vendor))
            ->flatten()
            ->push(base_path())
            ->map(fn ($path) => new Source($path));
    }

    private function state(Source $source): Collection
    {
        return $source->providers()
            ->map(fn ($provider) => App::make($provider))
            ->map(fn ($provider) => [
                'store' => $provider->store(),
                'state'    => $provider->state(),
            ]);
    }
}
