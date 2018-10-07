<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\People\app\Models\Person;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Upgrade extends Command
{
    private const DeprecatedPermissions = [
        'core.discussions.taggableUsers', 'core.comments.getTaggableUsers',
    ];

    private const SelectPermissions = [
        'administration.owners.selectOptions', 'administration.people.selectOptions',
        'administration.teams.selectOptions', 'administration.users.selectOptions',
        'system.roles.selectOptions',
    ];

    private const OwnerPermissions = [
        'administration.owners.initTable', 'administration.owners.getTableData', 'administration.owners.exportExcel', 'administration.owners.create', 'administration.owners.edit', 'administration.owners.index', 'administration.owners.options', 'administration.owners.store', 'administration.owners.update', 'administration.owners.destroy',
    ];

    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso for 2.12.0';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        \DB::transaction(function () {
            $this->renameMigrations()
                ->renameOwners()
                ->addPersonIdToUserTable()
                ->insertPeople()
                ->dropColummnsFromUserTable()
                ->removeDeprecatedPermissions()
                ->renameSelectPermissions()
                ->renameNotificationsPermissions()
                ->renameOwnersPermissions()
                ->updateMenus();
        });
    }

    private function renameMigrations()
    {
        \DB::table('migrations')->whereMigration('2017_01_01_108000_create_owners_table')
            ->update([
                'migration' => '2017_01_01_108000_create_user_groups_table',
            ]);

        \DB::table('migrations')->whereMigration('2017_01_01_127000_create_structure_for_owners')
            ->update([
                'migration' => '2017_01_01_127000_create_structure_for_user_groups',
            ]);

        \DB::table('migrations')->whereMigration('2017_01_01_109000_create_owner_role_pivot_table')
            ->update([
                'migration' => '2017_01_01_109000_create_role_user_group_pivot_table',
            ]);

        return $this;
    }

    private function renameOwners()
    {
        if (!Schema::hasTable('owners')) {
            $this->info('The owners structure was already upgraded');

            return $this;
        }

        $this->info('Upgrading then owners structure');

        Schema::disableForeignKeyConstraints();

        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::rename('owners', 'user_groups');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->renameColumn('owner_id', 'group_id');
            $table->foreign('group_id')->references('id')->on('user_groups');
        });

        Schema::table('owner_role', function (Blueprint $table) {
            $table->dropPrimary(['owner_id', 'role_id']);
            $table->dropForeign(['owner_id']);
            $table->renameColumn('owner_id', 'user_group_id');
        });

        Schema::rename('owner_role', 'role_user_group');

        Schema::table('role_user_group', function (Blueprint $table) {
            $table->foreign('user_group_id')->references('id')->on('user_groups');

            $table->primary(['role_id', 'user_group_id']);
        });

        Schema::enableForeignKeyConstraints();

        $this->info('Then owners structure was successfully upgraded');

        return $this;
    }

    private function addPersonIdToUserTable()
    {
        if (Schema::hasColumn('users', 'person_id')) {
            $this->info('The users table was already updated');

            return $this;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->integer('person_id')->unsigned()->index()->nullable()->after('id');
        });

        return $this;
    }

    private function insertPeople()
    {
        if (!Schema::hasTable('people')) {
            return $this;
        }

        if (Person::first()) {
            $this->info('The people table alreay has entries. The upgrade was probably performed');

            return $this;
        }

        $this->info('Inserting people');

        User::chunk(100, function ($users) {
            $users->each(function ($user) {
                $user->timestamps = false;

                $person = new Person([
                    'name' => trim($user->first_name.' '.$user->last_name),
                    'appellative' => $user->first_name,
                    'phone' => $user->phone,
                    'created_at' => $user->created_at,
                ]);

                $person->email = $user->email;

                $person->save();

                $user->person_id = $person->id;

                $user->save();
            });
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('person_id')->unsigned()->nullable(false)->change();
        });

        $this->info('Finished inserting people');

        return $this;
    }

    private function dropColummnsFromUserTable()
    {
        if (!Schema::hasTable('people')) {
            return $this;
        }

        if (!Schema::hasColumn('users', 'first_name')) {
            $this->info('The users table was already updated');

            return $this;
        }

        $this->info('Updating users table');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'phone']);
        });

        $this->info('Users table was successfully updated');

        return $this;
    }

    private function removeDeprecatedPermissions()
    {
        $this->info('Removing deprecated permissions');

        Permission::whereIn('name', self::DeprecatedPermissions)
            ->delete();

        $this->info('Deprecated permissions were successfully removed');

        return $this;
    }

    private function renameSelectPermissions()
    {
        $this->info('Renaming select options permissions');

        Permission::whereIn('name', self::SelectPermissions)
            ->get()
            ->each(function ($permission) {
                $permission->update([
                    'name' => Str::replaceFirst('selectOptions', 'options', $permission->name),
                ]);
            });

        Permission::whereName('core.addresses.countriesSelectOptions')
            ->update(['name' => 'core.addresses.countryOptions']);

        $this->info('Select options permissions were successfully renamed');

        return $this;
    }

    private function renameNotificationsPermissions()
    {
        $this->info('Renaming notifications permissions');

        Permission::whereName('core.notifications.getCount')
            ->update(['name' => 'core.notifications.count']);

        Permission::whereName('core.notifications.getList')
            ->delete();

        Permission::whereName('core.notifications.markAsRead')
            ->update(['name' => 'core.notifications.update']);

        Permission::whereName('core.notifications.markAllAsRead')
            ->update(['name' => 'core.notifications.updateAll']);

        Permission::whereName('core.notifications.clear')
            ->update(['name' => 'core.notifications.destroy']);

        Permission::whereName('core.notifications.clearAll')
            ->update(['name' => 'core.notifications.destroyAll']);

        $this->info('Notifications permissions were successfully renamed');

        return $this;
    }

    private function renameOwnersPermissions()
    {
        $this->info('Renaming owner permissions');

        Permission::whereIn('name', self::OwnerPermissions)
            ->get()
            ->each(function ($permission) {
                $permission->update([
                    'name' => Str::replaceFirst('owners', 'userGroups', $permission->name),
                ]);
            });

        $this->info('Owner permissions were successfully renamed');

        return $this;
    }

    private function updateMenus()
    {
        $this->info('Updating menus');

        Menu::whereName('Owners')->update([
            'name' => 'User Groups',
            'icon' => 'users',
            'link' => 'administration.userGroups.index',
        ]);

        Menu::whereName('Users')->update([
            'icon' => 'user',
        ]);

        $this->info('Menus updated successfully');

        return $this;
    }
}
