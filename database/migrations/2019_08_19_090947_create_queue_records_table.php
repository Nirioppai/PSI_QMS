<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue_name')->default('Not Set');
            $table->string('record_type')->default('Not Set');
            $table->string('record_name')->default('Not Set');
            $table->integer('record_station_number')->default(0);
            $table->integer('record_number')->default(0);
            $table->integer('record_number_of_stations')->default(0);
            $table->integer('record_number_of_windows')->default(0);
            $table->string('record_is_priority_window')->default('Yes');
            $table->string('record_admin')->default('Not Set');
            $table->integer('queue_status')->default(0);
            $table->string('record_creator')->default('Not Set');
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
        Schema::dropIfExists('queue_records');
    }
}
