<?php namespace App\EventStore;

class EventBuilder
{
    private $id_generator;
    private $datetime_generator;
    private $event;
    
    public function __construct(IDGenerator $id_generator, DateTimeGenerator $datetime_generator)
    {
        $this->id_generator = $id_generator;
        $this->datetime_generator = $datetime_generator;
        
        $this->setup_fresh_event();
    }
    
    private function setup_fresh_event()
    {
        $this->event = new Event(); 
        $this->event->schema = new Schema();
        $this->event->domain = new Domain();
    }
    
    public function set_id($id)
    {
        $this->event->id = $id;
        return $this;
    }
    
    public function set_schema_id($id)
    {
        $this->event->schema->id = $id;
        return $this;
    }
    
    public function set_schema_aggregate_id($id)
    {
        $this->event->schema->aggregate_id = $id;
        return $this;
    }
    
    public function set_domain_aggregate_id($id)
    {
        $this->event->domain->aggregate_id = $id;
        return $this;
    }
    
    public function set_domain_payload($payload)
    {
        $this->event->domain->payload = $payload;
        return $this;
    }
    
    public function set_occured_at($datetime)
    {
        $this->event->occured_at = $datetime;
        return $this;
    }
    
    
    public function build()
    {
        $event = $this->event;
        $event->id = $event->id ?: $this->id_generator->generate();
        $event->occured_at = $event->occured_at ?: $this->datetime_generator->generate();
        
        $this->setup_fresh_event();
        
        return $event;
    }
}
