<?php

namespace App\DataTable;

use LaravelEnso\Core\App\Enums\IsActiveEnum;
use LaravelEnso\DataTable\App\Classes\Abstracts\TableStructure;

class OwnersTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [

            'crtNo'         => __('#'),
            'actionButtons' => __('Actions'),
            'headerAlign'   => 'center',
            'bodyAlign'     => 'center',
            'tableClass'    => 'table display',
            'enumMappings'  => [
                'is_active' => IsActiveEnum::class,
            ],
            'columns'         => [

                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'name',
                ],
                1 => [
                    'label' => __('Fiscal Code'),
                    'data'  => 'fiscal_code',
                    'name'  => 'fiscal_code',
                ],
                2 => [
                    'label' => __('City'),
                    'data'  => 'city',
                    'name'  => 'city',
                ],
                3 => [
                    'label' => __('County'),
                    'data'  => 'county',
                    'name'  => 'county',
                ],
                4 => [
                    'label' => __('Address'),
                    'data'  => 'address',
                    'name'  => 'address',
                ],
                5 => [
                    'label' => __('Contact'),
                    'data'  => 'contact',
                    'name'  => 'contact',
                ],
                6 => [
                    'label' => __('Phone'),
                    'data'  => 'phone',
                    'name'  => 'phone',
                ],
                7 => [
                    'label' => __('Email'),
                    'data'  => 'email',
                    'name'  => 'email',
                ],
                8 => [
                    'label' => __('Active'),
                    'data'  => 'is_active',
                    'name'  => 'is_active',
                ],
            ],
        ];
    }
}
