<?php namespace Test\Interpreter;

class EventStore
{
    private static $events = [];
    
    public function fetch($aggregate_id, $aggregate_type_id)
    {
        return self::$events;
    }
    
    public function store(array $events)
    {
        self::$events = $events;
    }
}
