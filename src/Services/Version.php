<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Version
{
    private const Endpoint = 'https://api.github.com/repos/laravel-enso/enso/releases/latest';

    private $release;

    public function __construct()
    {
        $this->channels = new Collection();
    }

    public function latest()
    {
        $this->release ??= Http::get(self::Endpoint)->json();

        return $this->release['tag_name'] ?? null;
    }

    public function coreVersion()
    {
        $coreConifg = require __DIR__.'/../../config/config.php';

        return $coreConifg['version'];
    }

    public function isOutdated()
    {
        return $this->coreVersion() !== $this->current();
    }

    public function current()
    {
        return Config::get('enso.config.version');
    }

    public function update()
    {
        $config = File::get(config_path('enso/config.php'));

        $config = preg_replace("/'version'.*=>.*,/", "'version' => '{$this->coreVersion()}',", $config);

        File::put(config_path('enso/config.php'), $config);
    }
}
