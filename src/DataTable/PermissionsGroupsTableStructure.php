<?php

namespace LaravelEnso\Core\DataTable;

use LaravelEnso\DataTable\Abstracts\TableStructure;

class PermissionsGroupsTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            'crtNo'         => __('#'),
            'actionButtons' => __('Actions'),
            'render'        => [2, 3],
            'headerAlign'   => 'center',
            'bodyAlign'     => 'center',
            'tableClass'    => 'table display compact',
            'dom'           => 'lfrtip',

            'columns'         => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'permissions_groups.name',
                ],
                1 => [
                    'label' => __('Description'),
                    'data'  => 'description',
                    'name'  => 'description',
                ],
                2 => [
                    'label' => __('Created At'),
                    'data'  => 'created_at',
                    'name'  => 'created_at',
                ],
                3 => [
                    'label' => __('Updated At'),
                    'data'  => 'updated_at',
                    'name'  => 'updated_at',
                ],
            ],
        ];
    }
}
