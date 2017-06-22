<?php

namespace LaravelEnso\Core\app\Classes\StructureManager;

use Illuminate\Database\Migrations\Migration;

abstract class StructureMigration extends Migration
{
    protected $role;
    protected $group;
    protected $permissions;
    protected $parentMenu;
    protected $menu;

    public function up()
    {
        $structureManager = new StructureCreator();

        if ($this->group && !empty($this->group)) {
            $structureManager->setPermissionsGroup(($this->group));
            $structureManager->setPermissions(($this->permissions));
        }

        if ($this->parentMenu) {
            $structureManager->setParentMenu($this->parentMenu);
        }

        if ($this->menu) {
            $structureManager->setMenu($this->menu);
        }

        if ($this->role) {
            $structureManager->setRole($this->role);
        }

        $structureManager->create();
    }

    public function down()
    {
        $structureManager = new StructureDestroyer();

        if ($this->group && !empty($this->group)) {
            $structureManager->setPermissionsGroup(($this->group));
            $structureManager->setPermissions(($this->permissions));
        }

        if ($this->menu) {
            $structureManager->setMenu($this->menu);
        }

        $structureManager->destroy();
    }
}
