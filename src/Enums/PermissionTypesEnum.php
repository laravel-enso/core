<?php

namespace LaravelEnso\Core\Enums;

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
