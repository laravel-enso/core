<?php

namespace LaravelEnso\Core\Classes\MigrationSupport;

use LaravelEnso\Core\Models\PermissionsGroup;

trait MigrationSupport
{
    private function up()
    {
        //fixme: to be removed after migrating all apps to Laravel Enso v3
        if ($this->structureExists()) {
            return;
        }

        $structureManager = new StructureCreation();

        if ($this->permissionsGroup) {
            $structureManager->setPermissionsGroup(($this->permissionsGroup));
        }

        if ($this->menu) {
            $migrationSuport->setMenu($this->menu);
        }

        $structureManager->create();
    }

    private function down()
    {
        $structureManager = new StructureDestruction($this->permissionsGroup);
        if ($this->menu) {
            $structureManager->setMenu($this->menu);
        }

        $structureManager->down();
    }

    private function structureExists()
    {
        return PermissionsGroup::whereName($this->permissionsGroup['name'])->get()->count()
            || Menu::whereName($this->menu['name'])->get()->count();
    }
}
