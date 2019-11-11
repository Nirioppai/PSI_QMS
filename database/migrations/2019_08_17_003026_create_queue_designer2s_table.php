<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueDesigner2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_designer2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue_name')->default('Not Set');
            $table->string('station_name')->default('Not Set');
            $table->integer('station_number')->default(0);
            $table->integer('window_number')->default(0);
            $table->string('is_priority')->default('Not Set');
            $table->string('username')->default('Not Set');
            $table->string('password')->default('Not Set');
            $table->string('created_by')->default('Not Set');
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
        Schema::dropIfExists('queue_designer2s');
    }
}
