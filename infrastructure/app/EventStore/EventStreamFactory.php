<?php namespace Infrastructure\App\EventStore;

use App\EventStore\EventBuilder;

class EventStreamFactory
{
    private $event_builder;
    
    public function __construct(EventBuilder $event_builder)
    {
        $this->event_builder = $event_builder;
    }
    
    public function aggregate_id(AggregateID $aggregate_id)
    {
        return new EventStream($this->event_builder, $aggregate_id);
    }
}

