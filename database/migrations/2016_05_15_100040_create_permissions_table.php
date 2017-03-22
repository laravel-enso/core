<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permissions_group_id')->unsigned()->index();
            $table->foreign('permissions_group_id')->references('id')->on('permissions_groups')->onUpdate('restrict')->onDelete('restrict');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->tinyInteger('type');
            $table->timestamps();
        });

        DB::insert(

            "INSERT INTO `permissions` (`permissions_group_id`, `name`, `description`, `type`) VALUES
                (1,'home','Welcome Page',0),

                (2,'core.avatars.destroy','Delete Avatar',1),
                (2,'core.avatars.show','Return Selected Avatar',0),
                (2,'core.avatars.store','Upload Avatar',1),

                (3,'core.dataTables.initTable','Init Table',0),
                (3,'core.dataTables.getData','Get Data for DataTables',0),
                (3,'core.dataTables.setData','Update data from DataTables Editor',1),

                -- (4,'core.notifications.getCount','Set All notifications as Read',1),
                -- (4,'core.notifications.getList','Get Users Notifications Count',0),
                -- (4,'core.notifications.markAsRead','Get Users Notifications List',0),
                -- (4,'core.notifications.setIsRead','Set Notifications as Read',1),

                -- (5,'core.documents.upload','Upload Docs',1),
                -- (5,'core.documents.list','List Documents for Documentable',0),
                -- (5,'core.documents.show','Show Document',0),
                -- (5,'core.documents.download','Download Document',0),
                -- (5,'core.documents.destroy','Delete Document',1),

                (6,'core.export.getUsers','Generate Users Export',0),

                -- (7,'core.comments.list','List Comments for Commentable',0),
                -- (7,'core.comments.post','Post Comment',1),
                -- (7,'core.comments.show','Show Comment',0),
                -- (7,'core.comments.update','Update Comment',1),
                -- (7,'core.comments.destroy','Delete Comment',1),
                -- (7,'core.comments.getUsersList','Get Users List For Tagging',0),

                (8,'administration.owners.initTable','Init table for owners menu',0),
                (8,'administration.owners.getTableData','Get table data for owners',0),
                (8,'administration.owners.create','Create Owner',1),
                (8,'administration.owners.edit','Edit Existing Owner',1),
                (8,'administration.owners.index','Show Owners',0),
                (8,'administration.owners.getOptionsList','Get Options List For Vue Select',0),
                (8,'administration.owners.store','Save Owner',1),
                (8,'administration.owners.update','Update Owner',1),
                (8,'administration.owners.destroy','Delete Owner',1),

                (9,'administration.users.initTable','Init Table for Users',0),
                (9,'administration.users.getTableData','Get Table Data',0),
                (9,'administration.users.setTableData','Set data for users',1),
                (9,'administration.users.create','Create User',1),
                (9,'administration.users.edit','Edit Existing User',1),
                (9,'administration.users.index','Show Users',0),
                (9,'administration.users.show','Display User Information',0),
                (9,'administration.users.store','Save User',1),
                (9,'administration.users.update','Update User',1),
                (9,'administration.users.destroy','Delete User',1),
                (9,'administration.users.updateProfile','Update User\'s Profile',1),
                (9, 'administration.users.stopImpersonating','Stop Impersonating User',1),
                (9, 'administration.users.impersonate','Impersonate User',1),

                (10,'dashboard','Dashboard Index',0),

                (11,'system.menus.getTableData','Get table data for menus',0),
                (11,'system.menus.initTable','Init table for menus menu',0),
                (11,'system.menus.create','Create Menu',1),
                (11,'system.menus.edit','Edit Existing Menu',1),
                (11,'system.menus.index','Show Menus',0),
                (11,'system.menus.reorder','Reorder Menus',1),
                (11,'system.menus.setOrder','Set New Menus Order',1),
                (11,'system.menus.store','Save Menu',1),
                (11,'system.menus.update','Update Menu',1),
                (11,'system.menus.destroy','Delete Menu',1),

                (12,'system.permissionsGroups.index','Permissions Groups Index',0),
                (12,'system.permissionsGroups.create','Create Permissions Group',1),
                (12,'system.permissionsGroups.edit','Edit Existing Permissions Group',1),
                (12,'system.permissionsGroups.store','Save Permissions Group',1),
                (12,'system.permissionsGroups.update','Update Permissions Group',1),
                (12,'system.permissionsGroups.destroy','Delete Permissions Group',1),
                (12,'system.permissionsGroups.getTableData','Get table data for permissionsgroups',0),
                (12,'system.permissionsGroups.initTable','Init table data for permissiongroups',0),

                (13,'system.permissions.initTable','Init table data for permissions',0),
                (13,'system.permissions.getTableData','Get table data for permissions',0),
                (13,'system.permissions.create','Create Permission',1),
                (13,'system.permissions.edit','Edit Existing Permission',1),
                (13,'system.permissions.index','Show Permissions',0),
                (13,'system.permissions.store','Save Permission',1),
                (13,'system.permissions.update','Update Permission',1),
                (13,'system.permissions.destroy','Delete Permission',1),

                (13,'system.resourcePermissions.create','Create Resource Permission',1),
                (13,'system.resourcePermissions.store','Store Resource Permission',1),

                (14 ,'system.roles.getTableData','Get table data for roles',0),
                (14,'system.roles.initTable','Init table for roles menu',0),
                (14,'system.roles.create','Create Role',1),
                (14,'system.roles.edit','Edit Existing Role',1),
                (14,'system.roles.index','Show Roles List',0),
                (14,'system.roles.store','Save Role',1),
                (14,'system.roles.update','Update Role',1),
                (14,'system.roles.destroy','Delete Role',1),
                (14,'system.roles.getOptionsList','Get Permissions for Role',1),
                (14,'system.roles.getPermissions','Get Role Permissions',0),
                (14,'system.roles.setPermissions','Set Permissions for Role',1),

                (15,'system.tutorials.getTableData','Get table data for tutorials',0),
                (15,'system.tutorials.initTable','Init table data for tutorials',0),
                (15,'system.tutorials.create','Create Tutorial',1),
                (15,'system.tutorials.edit','Edit Tutorial',1),
                (15,'system.tutorials.index','List Tutorials',0),
                (15,'system.tutorials.store','Save Tutorial',1),
                (15,'system.tutorials.update','Update Tutorial',1),
                (15,'system.tutorials.getTutorial','Load Tutorial',0),
                (15,'system.tutorials.destroy','Delete Tutorial',1),

                -- (16,'system.logs.index','Logs index',0),
                -- (16,'system.logs.show','Show Log',0),
                -- (16,'system.logs.download','Download Log',0),
                -- (16,'system.logs.destroy','Delete Log',1),

                (17,'system.localisation.initTable','Init table data for localisation',0),
                (17,'system.localisation.getTableData','Get table data for localisation',0),
                (17,'system.localisation.create','Create Langugage',1),
                (17,'system.localisation.edit','Edit Language',1),
                (17,'system.localisation.editTexts','Edit Language File',1),
                (17,'system.localisation.getLangFile','Get Selected Lang File Content',0),
                (17,'system.localisation.index','Localisation Index',0),
                (17,'system.localisation.saveLangFile','Save Lang File',1),
                (17,'system.localisation.store','Save Language',1),
                (17,'system.localisation.update','Save edited language',1),
                (17,'system.localisation.destroy','Delete Language',1),

                (18,'core.preferences.setPreferences','Set User Preferences',1),
                (18,'core.preferences.resetToDefaut','Reset to default preferences',1)"
        );

        $now = "'".date('Y-m-d H:i:s')."'";

        DB::update("update `permissions` set created_at = $now, updated_at = $now");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
