<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class IOtypes extends Enum
{
    const Import = 1;
    const Export = 2;

    protected static $data = [
        self::Import => 'import',
        self::Export => 'export',
    ];
}
