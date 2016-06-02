<?php namespace App\EventStore;

class Schema
{
    public $event_id; // ID of this event type
    public $aggregate_id; // ID of the this aggregate type
}
