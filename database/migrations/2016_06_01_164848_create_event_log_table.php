<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventLogTable extends Migration
{
    public function up()
    {
        $statement = "
            CREATE TABLE `event_log` (
            `event_id` TEXT NOT NULL,
            `command_id` TEXT NOT NULL,
            `aggregate_id` TEXT NOT NULL,
            `schema_event_id` TEXT NOT NULL,
            `schema_aggregate_id` TEXT NOT NULL,
            `occured_at` TEXT NOT NULL,
            `order` int unsigned AUTO_INCREMENT,
            `payload` mediumtext NOT NULL,
            PRIMARY KEY (`order`)
          );        
        ";
        DB::statement($statement);
    }

    public function down()
    {
        Schema::drop("event_log");
    }
}
