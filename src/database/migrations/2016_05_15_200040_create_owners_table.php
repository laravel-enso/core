<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique('name');
            $table->string('fiscal_code')->unique('fiscal_code')->nullable();
            $table->string('reg_com_nr')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_individual')->default(0);
            $table->boolean('is_active')->default(0);
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
        Schema::drop('owners');
    }
}
