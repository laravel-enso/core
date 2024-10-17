<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('queue');
            $table->longText('payload');
            $table->tinyInteger('attempts')->unsigned();

            $table->integer('reserved_at')->unsigned()->nullable();
            $table->integer('available_at')->unsigned();
            $table->integer('created_at')->unsigned();

            $table->index(['queue', 'reserved_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
