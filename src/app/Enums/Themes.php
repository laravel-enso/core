<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class Themes extends Enum
{
    protected static function attributes()
    {
        return config('enso.themes');
    }
}
