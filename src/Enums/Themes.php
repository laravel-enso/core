<?php

namespace LaravelEnso\Core\Enums;

use LaravelEnso\Enums\Services\Enum;

class Themes extends Enum
{
    protected static function data(): array
    {
        return config('enso.themes');
    }
}
