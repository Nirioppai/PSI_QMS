<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWindowAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('window_admins', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('username')->default('Not Set');
          $table->string('password')->default('Not Set');
          $table->string('queue_name')->default('Not Set');
          $table->integer('window_station_number')->default(0);
          $table->integer('window_number')->default(0);
          $table->string('is_priority_window')->default(1);
          $table->string('record_admin')->default('Not Set');
          $table->integer('queue_status')->default(0);
          $table->string('record_creator')->default('Not Set');
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
        Schema::dropIfExists('window_admins');
    }
}
