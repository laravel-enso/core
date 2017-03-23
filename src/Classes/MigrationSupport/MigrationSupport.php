<?php

namespace LaravelEnso\Core\Classes\MigrationSupport;

use LaravelEnso\Core\Classes\MigrationSupport\StructureDestruction;
use LaravelEnso\Core\Models\Menu;
use LaravelEnso\Core\Models\PermissionsGroup;

trait MigrationSupport
{
    public function up()
    {
        $structureManager = new StructureCreation();

        if ($this->permissionsGroup && !empty($this->permissionsGroup)) {
            $structureManager->setPermissionsGroup(($this->permissionsGroup));
            $structureManager->setPermissions(($this->permissions));
        }

        if ($this->menu && !empty($this->menu)) {
            $structureManager->setMenu($this->menu);
        }

        $structureManager->create();
    }

    public function down()
    {
        $structureManager = new StructureDestruction($this->permissionsGroup);

        if ($this->menu) {
            $structureManager->setMenu($this->menu);
        }

        $structureManager->destroy();
    }
}
