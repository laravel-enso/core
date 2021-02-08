<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Version
{
    private $release;

    public function __construct()
    {
        $this->channels = new Collection();
    }

    public function latest()
    {
        $this->release ??= $release = Http::get('https://api.github.com/repos/laravel-enso/enso/releases/latest')
            ->json();

        return $this->release['tag_name'] ?? null;
    }

    public function isOutdated()
    {
        return $this->latest() !== $this->current();
    }

    public function current()
    {
        return Config::get('enso.config.version');
    }

    public function update()
    {
        $config = File::get(config_path('enso/config.php'));

        $config = preg_replace("/'version'.*=>.*,/", "'version' => '{$this->latest()}',", $config);

        File::put(config_path('enso/config.php'), $config);
    }
}
