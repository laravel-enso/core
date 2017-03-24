<?php

namespace App\DataTable;

use LaravelEnso\Core\App\Enums\IsActiveEnum;
use LaravelEnso\DataTable\App\Classes\Abstracts\TableStructure;

class UsersTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [

            /* current number for each line */
            'crtNo'              => __('#'),
            /* buttons with available actions */
            'actionButtons'      => __('Actions'),
            /* columns where custom rendering is applied
             * Note: a global 'customRender function needs to exist on the same page
             * as the table with the custom rendering */
            //'render'             => [2],
            /* the number of the column where the total is displayed
             * and the table/column used to calculate the total  */
            // 'totals'             => [4 => 'users.phone'],
            /* computed responsive priority will be  1 for first column
             * and will increment with one for each consecutive column
             */
            'responsivePriority' => [1, 2, 5, 7],
            /* list of columns that are not searchable */
            'notSearchable'      => [7],
            /* list of columns that are not sortable */
            // 'notSortable'        => [4],
            /* list of editable columns
             * Note:  the $editableModel parameter is needed, and
             * only attributes of this model are editable i.e. you can't
             * edit attributes of 'joined' models/tables
             */
            // 'editable'           => [1, 4],
            /* if none is given, by default, 'lfrtip' is used.
             * See datatables.net documentation */
            'dom'                => 'lfrtip',
            /* table header alignment. The dt-head-* class is used,
             * i.e. dt-head-center in this case  */
            'headerAlign'        => 'center',
            /* table body alignment. The dt-body-* class is used in this example */
            'bodyAlign'          => 'center',
            /* the class of the '<table> element */
            'tableClass'         => 'table display compact',
            /* list of columns to be displayed, given by position - translation key
             * The translation will be used in the table column header.
             * Note: 'special' columns such as crtNo/actionButtons should NOT be given here */
            'enumMappings' => [
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
                    'label' => __('Nin'),
                    'data'  => 'nin',
                    'name'  => 'nin',
                ],
                4 => [
                    'label' => __('Phone'),
                    'data'  => 'phone',
                    'name'  => 'users.phone',
                ],
                5 => [
                    'label' => __('Email'),
                    'data'  => 'email',
                    'name'  => 'users.email',
                ],
                6 => [
                    'label' => __('Role'),
                    'data'  => 'role',
                    'name'  => 'roles.name',
                ],
                7 => [
                    'label' => __('Active'),
                    'data'  => 'is_active',
                    'name'  => 'users.is_active',
                ],
            ],
        ];
    }
}
