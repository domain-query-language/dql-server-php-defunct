<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStreamLockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statement = "
            CREATE TABLE `event_stream_lock` (
            `stream_id` TEXT UNIQUE,
            `datetime` TEXT
          );        
        ";
        DB::statement($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("event_stream_lock");
    }
}
