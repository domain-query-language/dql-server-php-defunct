<?php namespace Test\EventStore;

class EventStream extends \Test\TestCase
{
    private $event_stream;
    
    public function setUp()
    {
        $this->event_stream = new EventStream();
    }
    
    public function test_can_foreach_through_stream()
    {
        foreach ($this->event_stream as $event) {
            
        }
    }
}