<?php

namespace LaravelEnso\Core\Services;

use LaravelEnso\Helpers\Services\JsonReader;

class DefaultPreferences
{
    public static function data(): object
    {
        $path = resource_path('preferences.json');

        return (new JsonReader($path))->object();
    }
}
