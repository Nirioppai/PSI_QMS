<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_admins', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name')->default('Not Set');
          $table->string('username')->unique();
          $table->string('password');
          $table->string('created_by')->default('Not Set');//ID of logged in 
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
        Schema::dropIfExists('queue_admins');
    }
}
