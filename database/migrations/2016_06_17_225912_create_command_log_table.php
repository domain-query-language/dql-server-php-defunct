<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommandLogTable extends Migration
{
    public function up()
    {
        $statement = "
            CREATE TABLE `command_log` (
            `command_id` TEXT NOT NULL,
            `aggregate_id` TEXT NOT NULL,
            `schema_command_id` TEXT NOT NULL,
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
        Schema::drop("command_log");
    }
}
