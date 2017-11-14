<?php

namespace LaravelEnso\Core\app\DataTable;

use LaravelEnso\DataTable\app\Classes\TableStructure;

class OwnersTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            'name'          => __('Registered Entities'),
            'icon'          => 'fa fa-list-alt',
            'crtNo'         => __('#'),
            'actions'       => __('Actions'),
            'actionButtons' => ['edit', 'destroy'],
            'headerButtons' => ['create', 'exportExcel'],
            'headerAlign'   => 'center',
            'bodyAlign'     => 'center',
            'boolean'       => [2],
            'columns'       => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'name',
                ],
                1 => [
                    'label' => __('Description'),
                    'data'  => 'description',
                    'name'  => 'description',
                ],
                2 => [
                    'label' => __('Active'),
                    'data'  => 'is_active',
                    'name'  => 'is_active',
                ],
            ],
        ];
    }
}
