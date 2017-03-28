<?php

use LaravelEnso\Core\app\Classes\StructureManager\StructureMigration;

class CreateStructureForExports extends StructureMigration
{
    protected $permissionsGroup = [
        'name' => 'export', 'description' => 'Exports Permissions Group',
    ];

    protected $permissions = [
        ['name' => 'export.getUsers', 'description' => 'Generates an xls users export and sends it by email to the user that made the request', 'type' => 1],
    ];
}
