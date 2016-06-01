<?php namespace App\EventStore;

class EventBuilder
{
    private $id_generator;
    private $event;
    
    public function __construct(IDGenerator $id_generator)
    {
        $this->id_generator = $id_generator;
        
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
    
    public function build()
    {
        $event = $this->event;
        $event->id = $event->id ?: $this->id_generator->generate();
        $event->occured_at = '2014-10-10 12:12:12';
        
        $this->setup_fresh_event();
        
        return $event;
    }
}
