<?php namespace App\CommandStore;

class Command
{
    public $command_id;
    public $aggregate_id;
    public $payload;
    
    /** @var Schema  */
    public $schema;
    
    public $occured_at;
}
