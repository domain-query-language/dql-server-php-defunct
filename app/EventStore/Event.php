<?php namespace App\EventStore;

class Event
{
    public $id;
    public $occured_at;
    
    /** @var Schema  */
    public $schema;
    
    /** @var Domain  */
    public $domain;
}
