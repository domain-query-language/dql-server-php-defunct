<?php namespace Infrastructure\App\Interpreter;

use App\EventStore\StreamID;

class EventStore implements \App\Interpreter\EventStore
{
    private $event_store;
    
    public function __construct(\App\EventStore\EventStore $event_store)
    {
        $this->event_store = $event_store;
    }
    
    public function fetch($domain_aggregate_id, $schema_aggregate_id)
    {
        $stream_id = new StreamID($schema_aggregate_id, $domain_aggregate_id);
        
        return $this->event_store->fetch($stream_id);
    }

    public function store(array $events)
    {
        $this->event_store->store($events);
    }

}
