<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW archive_views AS 
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
                             archives
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archive_views');
    }
}
