<?php namespace Infrastructure\App\EventStore;

use App\EventStore\EventBuilder;

class EventStreamFactory
{
    private $event_builder;
    
    public function __construct(EventBuilder $event_builder)
    {
        $this->event_builder = $event_builder;
    }
    
    public function aggregate_id($schema_id, $domain_id)
    {
        return new EventStream($this->event_builder, $schema_id, $domain_id);
    }
}

