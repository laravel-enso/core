<?php

namespace LaravelEnso\Core\app\DataTable;

use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\DataTable\app\Classes\TableStructure;

class UsersTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            'crtNo'              => __('#'),
            'actionButtons'      => __('Actions'),
            'responsivePriority' => [1, 2, 4, 6],
            'headerAlign'        => 'center',
            'bodyAlign'          => 'center',
            'tableClass'         => 'table display compact',
            'enumMappings'       => [
                'is_active' => IsActiveEnum::class,
            ],
            'columns'              => [
                0 => [
                    'label' => __('Entity'),
                    'data'  => 'owner',
                    'name'  => 'owners.name',
                ],
                1 => [
                    'label' => __('First Name'),
                    'data'  => 'first_name',
                    'name'  => 'first_name',
                ],
                2 => [
                    'label' => __('Last Name'),
                    'data'  => 'last_name',
                    'name'  => 'last_name',
                ],
                3 => [
                    'label' => __('Phone'),
                    'data'  => 'phone',
                    'name'  => 'users.phone',
                ],
                4 => [
                    'label' => __('Email'),
                    'data'  => 'email',
                    'name'  => 'users.email',
                ],
                5 => [
                    'label' => __('Role'),
                    'data'  => 'role',
                    'name'  => 'roles.name',
                ],
                6 => [
                    'label' => __('Active'),
                    'data'  => 'is_active',
                    'name'  => 'users.is_active',
                ],
            ],
        ];
    }
}
