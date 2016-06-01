<?php namespace Test\EventStore;

use Infrastructure\App\EventStore\EventStore;
use Infrastructure\App\EventStore\EventRepository;
use Infrastructure\App\EventStore\EventStreamFactory;
use Infrastructure\App\EventStore\EventStream;
use Infrastructure\App\EventStore\AggregateID;

class EventStoreTest extends \Test\TestCase 
{
    private $stub_event_repo;
    private $stub_event_factory;
    private $event_store;
    
    public function setUp()
    {
        $this->stub_event_repo = $this->getMockBuilder(EventRepository::class)
                ->disableOriginalConstructor()->getMock();
        $this->stub_event_factory = $this->getMockBuilder(EventStreamFactory::class)
                ->disableOriginalConstructor()->getMock();
        $this->event_store = new EventStore($this->stub_event_repo, $this->stub_event_factory);
    }
    
    public function test_takes_in_data()
    {
        $data = ['data'];
        
        $this->stub_event_repo->expects($this->once())
                 ->method('store')
                 ->with($this->equalTo($data));

        $this->event_store->store($data);
    }
    
    public function test_returns_stream()
    {   
        $aggregate_id = $this->getMockBuilder(AggregateID::class)
                ->disableOriginalConstructor()->getMock();
        
        $stream = new EventStream($this->stub_event_repo, $aggregate_id);
        $this->stub_event_factory->method('aggregate_id')
             ->willReturn($stream);
        
        $this->assertEquals($stream, $this->event_store->fetch($aggregate_id));
    }
}