<?php

namespace LaravelEnso\Core\DataTable;

use LaravelEnso\DataTable\Abstracts\TableStructure;

class MenusTableStructure extends TableStructure
{

	public function __construct()
	{
		$this->data = [

	        /* current number for each line */
	        'crtNo'         => __('#'),
	        /* buttons with available actions */
	        'actionButtons' => __('Actions'),
	        'notSearchable' => [2, 4, 5],
	        'render'        => [1, 4, 5],
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
	                'name'  => 'menus.name',
	            ],
	            1 => [
	                'label' => __('Icon'),
	                'data'  => 'icon',
	                'name'  => 'menus.icon',
	            ],
	            2 => [
	                'label' => __('Parent'),
	                'data'  => 'parent',
	                'name'  => 'parent_menus.name',
	            ],
	            3 => [
	                'label' => __('Link'),
	                'data'  => 'link',
	                'name'  => 'menus.link',
	            ],
	            4 => [
	                'label' => __('Created At'),
	                'data'  => 'created_at',
	                'name'  => 'menus.created_at',
	            ],
	            5 => [
	                'label' => __('Updated At'),
	                'data'  => 'updated_at',
	                'name'  => 'menus.updated_at',
	            ],
	        ],
	    ];
	}
}

