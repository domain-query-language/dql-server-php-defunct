<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statement = "
            CREATE TABLE `event_log` (
            `event_id` TEXT NOT NULL,
            `aggregate_id` TEXT NOT NULL,
            `schema_event_id` TEXT NOT NULL,
            `schema_aggregate_id` TEXT NOT NULL,
            `occured_at` datetime NOT NULL,
            `order` int unsigned AUTO_INCREMENT,
            `payload` mediumtext NOT NULL,
            PRIMARY KEY (`order`)
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
        Scheme::drop("event_log");
    }
}
