<?php namespace App\DQLServer;

class Command 
{
    public $command_id;
    public $aggregate_id;
    public $payload;
    public $timestamp;
    
    public function __construct($command_id, $aggregate_id, $payload, $timestamp=null)
    {
        $this->command_id = $command_id;
        $this->aggregate_id = $aggregate_id;
        $this->payload = $payload;
        $this->timestamp = $timestamp ?: date("Y-m-d H:i:s").".".microtime();
    }
}