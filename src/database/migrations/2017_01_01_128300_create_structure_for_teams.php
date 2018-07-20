<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForTeams extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'administration.teams', 'description' => 'Teams permissions group',
    ];

    protected $permissions = [
        ['name' => 'administration.teams.index', 'description' => 'Show teams', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.teams.edit', 'description' => 'Edit existing team', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.teams.store', 'description' => 'Store newly created team', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.teams.update', 'description' => 'Update edited team', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.teams.destroy', 'description' => 'Delete team', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.teams.selectOptions', 'description' => 'Get options for vue-select', 'type' => 0, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Teams', 'icon' => 'users-cog', 'link' => 'administration.teams.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
