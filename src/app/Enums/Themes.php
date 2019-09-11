<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class Themes extends Enum
{
    protected static function attributes()
    {
        return config('enso.themes');
    }
}
