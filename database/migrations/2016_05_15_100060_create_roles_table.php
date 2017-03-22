<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned()->index()->nullable();
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('restrict')->onDelete('restrict');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::insert(

            "INSERT INTO `roles` (`menu_id`,`name`, `display_name`, `description`) VALUES
                (1, 'admin','Administrator',NULL),
                (1, 'supervisor','Supervisor','Supervisor')"
        );

        $now = "'".date('Y-m-d H:i:s')."'";

        DB::update("update `roles` set created_at = $now, updated_at = $now");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
