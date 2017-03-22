<?php

namespace LaravelEnso\Core\DataTable;

use LaravelEnso\DataTable\Abstracts\TableStructure;

class RolesTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            /* current number for each line */
            'crtNo'         => __('#'),
            /* buttons with available actions */
            'actionButtons' => __('Actions'),
            'render'        => [3, 4],
            /* table header alignment. The dt-head-* class is used,
             * i.e. dt-head-center in this case  */
            'notSearchable' => [3, 4],
            'headerAlign'   => 'center',
            /* table body alignment. The dt-body-* class is used in this example */
            'bodyAlign'     => 'center',
            /* the class of the '<table> element */
            'tableClass'    => 'table display compact',
            /* if none is given, by default, 'lfrtip' is used.
             * See datatables.net documentation */
            'dom'           => 'lfrtip',
            /* list of columns to be displayed, given by position - translation key
             * The translation will be used in the table column header.
             * Note: 'special' columns such as crtNo/actionButtons should NOT be given here */
            'columns'         => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'name',
                ],
                1 => [
                    'label' => __('Display Name'),
                    'data'  => 'display_name',
                    'name'  => 'display_name',
                ],
                2 => [
                    'label' => __('Description'),
                    'data'  => 'description',
                    'name'  => 'description',
                ],
                3 => [
                    'label' => __('Created At'),
                    'data'  => 'created_at',
                    'name'  => 'created_at',
                ],
                4 => [
                    'label' => __('Updated At'),
                    'data'  => 'updated_at',
                    'name'  => 'updated_at',
                ],
            ],
        ];
    }
}
