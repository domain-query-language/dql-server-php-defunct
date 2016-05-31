<?php namespace Test\EventStore;

use App\EventStore\Event;
use App\EventStore\EventStore;
use App\EventStore\EventStream;

abstract class EventStoreTest extends \Test\TestCase 
{
    private $event_store;
    
    private $aggregate_id;
    private $aggregate_type_id;
    
    /**
     * @return EventStore
     */
    abstract protected function make_event_store();
    
    public function setUp()
    {
        $this->event_store = $this->make_event_store();
        
        $this->aggregate_id = "b5c4aca8-95c7-4b2b-8674-ef7c0e3fd16f";
        $this->aggregate_type_id = "a955d32b-0130-463f-b3ef-23adec9af469";
    }
    
    public function test_fetch_empty_set()
    {
        $stream = $this->event_store->fetch($this->aggregate_id, $this->aggregate_type_id);
        
        $count = 0;
        foreach ($stream as $event) {
            $count++;
        }
        
        $this->assertEquals(0, $count);
    }
    
    public function test_fetch_returns_an_event_stream()
    {
        $event = $this->getMockBuilder(Event::class)->getMock();
                
        $this->event_store->store([$event]);
        
        $stream = $this->event_store->fetch($this->aggregate_id, $this->aggregate_type_id);
        
        $this->assertInstanceOf(EventStream::class, $stream);
    }
}