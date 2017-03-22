<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions_groups', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();

        });

        DB::insert(

            "INSERT INTO `permissions_groups` (`name`, `description`) VALUES
                ('core.home','Home Group'),
                ('core.avatars','Avatars Permissions Group'),
                ('core.dataTables','Datatables Group'),
                ('core.notifications','Notifications Group'),
                ('core.documents','Documents Permissions Group'),
                ('core.export','Export Group'),
                ('core.comments','Comments Permissions Group'),
                ('administration.owners','Owners Group'),
                ('administration.users','Users Group'),
                ('dashboard','Dashboard Group'),
                ('system.menus','Menus Group'),
                ('system.permissionsGroups','Permissions Grops Group'),
                ('system.permissions','Permissions Group'),
                ('system.roles','Roles Group'),
                ('system.tutorials','Tutorials Group'),
                ('system.logs','Logs Group'),
                ('system.localisation','Localisation Group'),
                ('core.preferences','Preferences Group')"
        );

        $now = "'" . date("Y-m-d H:i:s") . "'";

        DB::update("update `permissions_groups` set created_at = $now, updated_at = $now");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions_groups');
    }
}
