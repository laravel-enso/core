<?php

namespace LaravelEnso\Core\App\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class IsActiveEnum extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [

            1 => __('Yes'),
            0 => __('No'),
        ];
    }
}
