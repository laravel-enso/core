<?php

namespace LaravelEnso\Core\App\Services;

use LaravelEnso\Helpers\App\Classes\JsonParser;

class DefaultPreferences
{
    public static function data(): object
    {
        return (new JsonParser(
            resource_path('preferences.json')
        ))->object();
    }
}
