<?php namespace Infrastructure\App\Interpreter;

use App\EventStore\StreamID;

class EventStore implements \App\Interpreter\EventStore
{
    private $event_store;
    
    public function __construct(\App\EventStore\EventStore $event_store)
    {
        $this->event_store = $event_store;
    }
    
    public function fetch($aggregate_id, $aggregate_type_id)
    {
        $stream_id = new StreamID($aggregate_type_id, $aggregate_id);
        
        return $this->event_store->fetch($stream_id);
    }

    public function store(array $events)
    {
        $this->event_store->store($events);
    }

}
