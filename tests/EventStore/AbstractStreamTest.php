<?php namespace Test\EventStore;

use App\EventStore\Event;

abstract class AbstractStreamTest extends \Test\TestCase
{
    private $event_stream;
    
    public function setUp()
    {
        $this->event_stream = $this->make_event_store();
    }
    
    /**
     * @return EventStream
     */
    abstract protected function make_event_store();
    
    public function test_can_foreach_through_stream()
    {
        foreach ($this->event_stream as $event) {
            $this->assertInstanceOf(Event::class, $event);
        }
    }
}