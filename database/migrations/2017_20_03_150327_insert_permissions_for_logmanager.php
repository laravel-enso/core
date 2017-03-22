<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Models\Permission;
use LaravelEnso\Core\Models\PermissionsGroup;
use LaravelEnso\Core\Models\Role;

class InsertPermissionsForLogManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionsGroup = PermissionsGroup::whereName('system.logs')->first();

        if ($permissionsGroup) {
            return;
        }

        \DB::transaction(function () {
            $permissionsGroup = new PermissionsGroup([
                'name'        => 'system.logs',
                'description' => 'logManager Permissions Group',
            ]);

            $permissionsGroup->save();

            $permissions = [
                [
                    'name'        => 'system.logs.index',
                    'description' => 'Logs index',
                    'type'        => 0,
                ],
                [
                    'name'        => 'system.logs.show',
                    'description' => 'Show Log',
                    'type'        => 0,
                ],
                [
                    'name'        => 'system.logs.download',
                    'description' => 'Download Log',
                    'type'        => 0,
                ],
                [
                    'name'        => 'system.logs.destroy',
                    'description' => 'Delete Log',
                    'type'        => 1,
                ],
            ];

            $adminRole = Role::whereName('admin')->first();

            foreach ($permissions as $permission) {
                $permission = new Permission($permission);
                $permissionsGroup->permissions()->save($permission);
                $adminRole->permissions()->save($permission);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::transaction(function () {
            $permissionsGroup = PermissionsGroup::whereName('system.logs')->first();
            $permissionsGroup->permissions->each->delete();
            $permissionsGroup->delete();
        });
    }
}
