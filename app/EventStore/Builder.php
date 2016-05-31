<?php namespace App\EventStore;

class Builder
{
    private $id_generator;
    private $event;
    
    public function __construct(IDGenerator $id_generator)
    {
        $this->id_generator = $id_generator;
        
        $this->event = new Event(); 
        $this->event->schema = new Schema();
        $this->event->domain = new Domain();
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
        $this->event->id = $this->id_generator->generate();
        $this->event->occured_at = '2014-10-10 12:12:12';
        return $this->event;
    }
}
