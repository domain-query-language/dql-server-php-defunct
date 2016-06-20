<?php namespace Test\Interpreter\Fake;

class EventStore implements \App\Interpreter\EventStore
{
    private static $events = [];
    
    public function fetch($domain_aggregate_id, $schema_aggregate_id)
    {
        return self::$events;
    }
    
    public function store(array $events)
    {
        self::$events = $events;
    }
    
    public function clear()
    {
        self::$events = [];
    }
}
