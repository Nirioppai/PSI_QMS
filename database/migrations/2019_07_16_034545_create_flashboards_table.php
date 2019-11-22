<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashboards', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('username')->unique();
          $table->string('password');
          $table->string('queue_name');
          $table->string('record_station_name');
          $table->integer('record_station_number');
          $table->integer('record_number_of_windows');
          $table->string('record_creator');
          $table->rememberToken();
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
        Schema::dropIfExists('flashboards');
    }
}
