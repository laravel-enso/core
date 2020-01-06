<?php

namespace LaravelEnso\Core\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class Themes extends Enum
{
    protected static function data(): array
    {
        return config('enso.themes');
    }
}
