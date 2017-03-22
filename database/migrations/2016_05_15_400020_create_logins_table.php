<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logins', function(Blueprint $table) {

			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
			$table->string('ip');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logins');
	}

}
