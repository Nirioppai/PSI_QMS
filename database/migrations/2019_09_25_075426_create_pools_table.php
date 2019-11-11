<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('queue_name')->default('Not Set');
            $table->integer('queue_number')->default(0);
            $table->string('client_name')->default('Not Set');
            $table->integer('queue_station_number')->default(0);
            $table->integer('queue_window_number')->default(0);
            $table->integer('queue_action')->default(0);
            $table->integer('queue_priority')->default(0);
            $table->string('queue_note')->default('');
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
        Schema::dropIfExists('pools');
    }
}
