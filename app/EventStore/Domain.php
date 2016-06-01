<?php namespace App\EventStore;

class Domain
{
    public $aggregate_id; // ID of the aggregate stream
    public $payload; // The data unique to this event type
}
