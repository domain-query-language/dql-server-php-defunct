<?php namespace App\EventStore;

use App\EventStore\EventBuilder;

class EventStreamFactory
{
    private $event_builder;
    
    public function __construct(EventBuilder $event_builder)
    {
        $this->event_builder = $event_builder;
    }
    
    public function aggregate_id(StreamID $aggregate_id)
    {
        return new AggregateEventStream($this->event_builder, $aggregate_id);
    }
    
    public function all()
    {
        return new EventStream();
    }
}


