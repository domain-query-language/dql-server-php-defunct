<?php namespace Test\Interpreter;

use Infrastructure\App\Interpreter\EventStore;
use App\EventStore\StreamID;

class EventStoreTest extends TestCase
{
    private $infrastructure_event_store;
    private $event_store;
    
    public function setUp()
    {
        $this->infrastructure_event_store = $this->getMockBuilder( \App\EventStore\EventStore::class)
            ->disableOriginalConstructor()->getMock();
        
        $this->event_store = new EventStore($this->infrastructure_event_store);
    }
    
    public function test_store()
    {
        $events = ['event'];
        
        $this->infrastructure_event_store->expects($this->once())
                 ->method('store')
                 ->with($this->equalTo($events));
        
        $this->event_store->store($events);
    }
        
    public function test_fetch()
    {
        $domain_aggregate_id = 'd';
        $schema_aggregate_id = 's';
        $stream = 's';
        
        $stream_id = new StreamID($schema_aggregate_id, $domain_aggregate_id);
        
        $this->infrastructure_event_store->expects($this->once())
                 ->method('fetch')
                 ->with($this->equalTo($stream_id))
                ->willReturn($stream);
        
        $this->assertEquals(
            $stream,
            $this->event_store->fetch($domain_aggregate_id, $schema_aggregate_id)
        );      
    }
}