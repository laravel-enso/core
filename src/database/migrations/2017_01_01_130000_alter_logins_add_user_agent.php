<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLoginsAddUserAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('logins', function (Blueprint $table) {

            $table->string('user_agent')->nullable();

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('logins', function (Blueprint $table) {


            $table->dropColumn('user_agent');
        });
    }
}
