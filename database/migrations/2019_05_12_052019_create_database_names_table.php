<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database_name', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('database_name')->default('N/A');
            $table->timestamps();
        });

        DB::statement("insert into database_name (database_name) select database()");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('database_names');
    }
}
