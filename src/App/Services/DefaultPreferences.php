<?php

namespace LaravelEnso\Core\App\Services;

use LaravelEnso\Helpers\App\Classes\JsonReader;

class DefaultPreferences
{
    public static function data(): object
    {
        return (new JsonReader(
            resource_path('preferences.json')
        ))->object();
    }
}
