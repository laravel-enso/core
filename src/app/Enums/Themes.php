<?php

namespace LaravelEnso\Core\app\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class Themes extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [
            0 => __('purple'),
            1 => __('purple-light'),
            2 => __('blue'),
            3 => __('blue-light'),
            4 => __('green'),
            5 => __('green-light'),
            6 => __('red'),
            7 => __('red-light'),
            8 => __('black'),
            9 => __('black-light'),

        ];
    }
}
