<?php namespace Test\EventStore;

use App\EventStore\EventStore;
use EventBuilder;

class EventStoreTest extends TestCase 
{
    private $event_store;
    
    private $aggregate_id;
    private $aggregate_type_id;
    
    public function setUp()
    {
        $this->event_store = $this->app->make(EventStore::class);
        
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
    
    public function test_add_events()
    {
        $event_builder = new EventBuilder();
        $event_builder->set_schema_id("14c3896d-092e-4370-bf72-2093facc9792");
        $event_builder->set_schema_aggregate_id($this->aggregate_type_id);
        $event_builder->set_domain_id($this->aggregate_id);
        $event_builder->set_domain_payload((object)['value'=>true]);
        
        $event = $event_builder->build();
        
        $this->event_store->store([$event]);
        
        $stream = $this->event_store->fetch($this->aggregate_id, $this->aggregate_type_id);
        
        $count = 0;
        $fetched_event = null;
        foreach ($stream as $event) {
            $fetched_event = $event;
            $count++;
        }
        
        $this->assertEquals(1, $count);
        $this->assertEquals($event, $fetched_event);
    }
}