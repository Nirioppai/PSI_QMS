<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateT0PoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW t0_pools AS 
                        SELECT 
                                id,
                                user_id,
                                queue_name,
                                queue_number,
                                client_name,
                                queue_station_number,
                                queue_window_number,
                                queue_action,
                                queue_priority,
                                queue_note,
                                created_at
                        FROM
                             pools
                        WHERE queue_action = '0'
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t0_pools');
    }
}
