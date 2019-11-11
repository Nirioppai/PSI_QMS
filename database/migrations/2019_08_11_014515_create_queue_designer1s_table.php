<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueDesigner1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_designer1s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue_name')->default('Not Set');
            $table->integer('number_of_stations')->default(0);
            $table->string('station_name')->default('Not Set');
            $table->integer('number_of_windows')->default(0);
            $table->integer('number_of_kiosks')->default(0);
            $table->integer('number_of_extra_pwd')->default(0);
            $table->string('station_admin')->default('Not Set');
            $table->string('created_by')->default(0);//ID of logged in 
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
        Schema::dropIfExists('queue_designer1');
    }
}
