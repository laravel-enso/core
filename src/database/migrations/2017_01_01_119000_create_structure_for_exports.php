<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForExports extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'export', 'description' => 'Exports permissions group',
    ];

    protected $permissions = [
        ['name' => 'export.getUsers', 'description' => 'Generates an xlsx users export and sends it by email to the user that made the request', 'type' => 1, 'default' => true],
    ];
}
