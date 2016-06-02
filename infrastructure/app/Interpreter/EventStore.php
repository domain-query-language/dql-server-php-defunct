<?php namespace Infrastructure\App\Interpreter;

use App\EventStore\StreamID;

class EventStore implements \App\Interpreter\EventStore
{
    private $event_store;
    private $event_builder;
    
    public function __construct(
        \App\EventStore\EventStore $event_store,
         \App\EventStore\EventBuilder $event_builder
    )
    {
        $this->event_store = $event_store;
        $this->event_builder = $event_builder;
    }
    
    public function fetch($domain_aggregate_id, $schema_aggregate_id)
    {
        $stream_id = new StreamID($schema_aggregate_id, $domain_aggregate_id);
        
        return $this->event_store->fetch($stream_id);
    }

    public function store(array $events)
    {
        $transformed_events = array_map(function($event){
            $this->event_builder->set_aggregate_id($event->domain->aggregate_id)
                    ->set_schema_event_id($event->schema->id)
                    ->set_schema_aggregate_id($event->schema->aggregate_id)
                    ->set_payload($event->domain->payload);
            
            return $this->event_builder->build();
                    
        }, $events);
        
        $this->event_store->store($transformed_events);
    }

}
