<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('flag');
            $table->timestamps();
        });

        DB::insert(

            "INSERT INTO `languages` (`id`, `name`, `display_name`, `flag`) VALUES
                (1,'ro','Romana','flag-icon-ro'),
                (2,'en','English-GB','flag-icon-gb')"
        );

        $now = "'".date('Y-m-d H:i:s')."'";

        DB::update("update `languages` set created_at = $now, updated_at = $now");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
