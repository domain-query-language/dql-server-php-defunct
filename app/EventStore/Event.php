<?php namespace App\EventStore;

class Event
{
    public $event_id;
    public $aggregate_id;
    public $payload;
    
    /** @var Schema  */
    public $schema;
    
    public $occured_at;
}
