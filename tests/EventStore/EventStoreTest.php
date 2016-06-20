<?php namespace Test\EventStore;

use App\EventStore\EventStore;
use App\EventStore\EventRepository;
use App\EventStore\EventStreamFactory;
use App\EventStore\AggregateEventStream;
use App\EventStore\StreamID;

class EventStoreTest extends \Test\TestCase 
{
    private $stub_event_repo;
    private $stub_event_factory;
    private $event_store;
    
    public function setUp()
    {
        $this->stub_event_repo = $this->mock(EventRepository::class);
        $this->stub_event_factory = $this->stub(EventStreamFactory::class);
        $this->event_store = new EventStore(
            $this->stub_event_repo->reveal(), 
            $this->stub_event_factory->reveal()
        );
    }

    public function test_takes_in_data()
    {
        $data = ['data'];
        
        $this->stub_event_repo->store($data)->shouldBeCalled();

        $this->event_store->store($data);
    }
    
    public function test_returns_stream()
    {   
        $aggregate_id = $this->dummy(StreamID::class);
        
        $stream = new AggregateEventStream($this->stub_event_repo->reveal(), $aggregate_id);
        $this->stub_event_factory->aggregate_id($aggregate_id)
             ->willReturn($stream);
        
        $this->assertEquals($stream, $this->event_store->fetch($aggregate_id));
    }
    
    public function test_can_fetch_full_stream()
    {
        $stream = 'stream';
        $this->stub_event_factory->all()
             ->willReturn($stream);
        
        $this->assertEquals($stream, $this->event_store->all());
    }
}