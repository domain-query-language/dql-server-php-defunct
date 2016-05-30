<?php namespace Test\Interpreter;

class EventStore
{
    private $events;
    
    public function fetch($aggregate_id, $aggregate_type_id)
    {
        return $this->events;
    }
    
    public function store(array $events)
    {
        $this->events = $events;
    }
}
