<?php

namespace App\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class PagesBreadcrumbsEnum extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [

            'createResource' => __('create resource'),
            'reorder'        => __('reorder'),
            'editTexts'      => __('edit texts'),
        ];
    }
}
