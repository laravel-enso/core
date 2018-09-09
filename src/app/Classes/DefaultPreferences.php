<?php

namespace LaravelEnso\Core\app\Classes;

use LaravelEnso\Helpers\app\Classes\JsonParser;

class DefaultPreferences
{
    public static function data()
    {
        return (new JsonParser(resource_path('preferences.json')))
            ->object();
    }
}
