<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class PermissionTypesEnum extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [

            0 => __('read'),
            1 => __('write'),
        ];
    }
}
