<?php

namespace LaravelEnso\Core\App\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class ThemesEnum extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [

            0 => __('purple'),
            1 => __('purple-light'),
            2 => __('blue'),
            3 => __('blue-light'),
            4 => __('black-light'),
        ];
    }
}
