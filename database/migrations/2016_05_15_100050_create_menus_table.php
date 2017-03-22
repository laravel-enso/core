<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('parent_id')->unsigned()->index()->nullable();
			$table->foreign('parent_id')->references('id')->on('menus')->onUpdate('restrict')->onDelete('restrict');
			$table->string('name');
			$table->string('icon');
			$table->integer('order')->default(999);
			$table->string('link')->nullable();
			$table->boolean('has_children')->default(0);
			$table->timestamps();
		});

		DB::insert(

			"INSERT INTO `menus` (`parent_id`, `name`, `icon`, `order`, `link`, `has_children`) VALUES
			    (NULL,'Dashboard','fa fa-fw fa-tachometer',1,'dashboard',0),
			    (NULL,'Administration','fa fa-fw fa-cogs',3,null,1),
			    (2,'Users','fa fa-fw fa-users',2,'administration/users',0),
			    (2,'Entities','fa fa-fw fa-list-alt',1,'administration/owners',0),
			    (NULL,'System','fa fa-fw fa-sliders',4,null,1),
			    (5,'Menus','fa fa-fw fa-list',1,'system/menus',0),
			    (5,'Permissions Groups','fa fa-fw fa-object-group',2,'system/permissionsGroups',0),
			    (5,'Permissions','fa fa-fw fa-exclamation-triangle',3,'system/permissions',0),
			    (5,'Logs','fa fa-fw fa-terminal',6,'system/logs',0),
			    (5,'Localisation','fa fa-fw fa-language',5,'system/localisation',0),
			    (5,'Tutorials','fa fa-fw fa-book',7,'system/tutorials',0),
			    (5,'Roles','fa fa-fw fa-universal-access',4,'system/roles',0)"
		);

        $now = "'" . date("Y-m-d H:i:s") . "'";

        DB::update("update `menus` set created_at = $now, updated_at = $now");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
	}

}
