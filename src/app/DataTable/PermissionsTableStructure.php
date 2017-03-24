<?php

namespace LaravelEnso\Core\App\DataTable;

use LaravelEnso\DataTable\App\Classes\Abstracts\TableStructure;

class PermissionsTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [

            'crtNo'         => __('#'),
            'actionButtons' => __('Actions'),
            'render'        => [4, 5],
            'headerAlign'   => 'center',
            'bodyAlign'     => 'center',
            'tableClass'    => 'table display compact',
            'dom'           => 'lfrtip',

            'columns'         => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'permissions.name',
                ],
                1 => [
                    'label' => __('Description'),
                    'data'  => 'description',
                    'name'  => 'permissions.description',
                ],
                2 => [
                    'label' => __('Type'),
                    'data'  => 'type',
                    'name'  => 'type',
                ],
                3 => [
                    'label' => __('Group'),
                    'data'  => 'grup',
                    'name'  => 'permissions_groups.name',
                ],
                4 => [
                    'label' => __('Created At'),
                    'data'  => 'created_at',
                    'name'  => 'permissions.created_at',
                ],
                5 => [
                    'label' => __('Updated At'),
                    'data'  => 'updated_at',
                    'name'  => 'permissions.updated_at',
                ],
            ],
        ];
    }
}
