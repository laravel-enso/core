<?php

namespace LaravelEnso\Core\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class IsIndividualEnum extends AbstractEnum
{

    public function __construct()
	{
		$this->data = [

	        1 => __('yes'),
	        0 => __('no'),
	    ];
	}
}
