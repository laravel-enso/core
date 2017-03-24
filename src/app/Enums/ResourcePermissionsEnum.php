<?php

namespace LaravelEnso\Core\App\Enums;

use LaravelEnso\Helpers\Classes\AbstractEnum;

class ResourcePermissionsEnum extends AbstractEnum
{
    public function __construct()
    {
        $this->data = [

            'resource'   => [

                ['name' => 'index', 'type' => 0, 'permissions_group_id' => null],
                ['name' => 'create', 'type' => 1, 'permissions_group_id' => null],
                ['name' => 'store', 'type' => 1, 'permissions_group_id' => null],
                ['name' => 'show', 'type' => 1, 'permissions_group_id' => null],
                ['name' => 'edit', 'type' => 1, 'permissions_group_id' => null],
                ['name' => 'update', 'type' => 1, 'permissions_group_id' => null],
                ['name' => 'destroy', 'type' => 1, 'permissions_group_id' => null],
            ],
            'dataTables' => [
                ['name' => 'initTable', 'type' => 0, 'permissions_group_id' => null],
                ['name' => 'getTableData', 'type' => 0, 'permissions_group_id' => null],
            ],
            'vueSelect'  => [
                ['name' => 'getOptionsList', 'type' => 0, 'permissions_group_id' => null],
            ],
        ];
    }
}
