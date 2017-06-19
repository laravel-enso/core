<?php

namespace App\DataTable;

use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\DataTable\app\Classes\TableStructure;

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
            'notSearchable' => [1],
            'enumMappings'  => [
                'is_active' => IsActiveEnum::class,
            ],
            'columns'       => [

                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'name',
                ],
                1 => [
                    'label' => __('Active'),
                    'data'  => 'is_active',
                    'name'  => 'is_active',
                ],
            ],
        ];
    }
}
