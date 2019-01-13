<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class IOEvents extends Enum
{
    const Started = 10;
    const Updated = 20;
    const Finalized = 30;

    protected static $data = [
        self::Started => 'io-started',
        self::Updated => 'io-updated',
        self::Finalized => 'io-stopped',
    ];
}
