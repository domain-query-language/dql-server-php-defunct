<?php namespace Test\Interpreter;

use Infrastructure\App\Interpreter\EventStore;
use App\EventStore\StreamID;

class EventStoreTest extends TestCase
{
    private $infrastructure_event_store;
    private $event_store;
    private $interpreter_event;
    
    public function setUp()
    {
        $this->infrastructure_event_store = $this->getMockBuilder( \App\EventStore\EventStore::class)
            ->disableOriginalConstructor()->getMock();
        
        $event_builder = $this->getMockBuilder(\App\EventStore\EventBuilder::class)
            ->disableOriginalConstructor()->getMock();
        
        $this->event_store = new EventStore($this->infrastructure_event_store, $event_builder);
        
        $this->interpreter_event = (object)[
            "schema"=> (object)[
                'id'=>'9be14fd0-80aa-4e82-bd30-df031a51f626',
                'aggregate_id'=>'01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "aggregate_id"=> "ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'payload'=> (object)['data'=>true]
            ]
        ];
    }
    
    public function test_translates_event_before_storing_it()
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