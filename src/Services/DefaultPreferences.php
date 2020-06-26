<?php

namespace LaravelEnso\Core\Services;

use LaravelEnso\Helpers\Services\JsonReader;

class DefaultPreferences
{
    public static function data(): object
    {
        return (new JsonReader(
            resource_path('preferences.json')
        ))->object();
    }
}
