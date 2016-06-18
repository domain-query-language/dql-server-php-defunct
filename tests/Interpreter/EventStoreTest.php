<?php namespace Test\Interpreter;

use Infrastructure\App\Interpreter\EventStore;
use App\EventStore\StreamID;

class EventStoreTest extends TestCase
{
    private $infrastructure_event_store;
    private $event_builder;
    private $event_store;
    private $interpreter_event;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->infrastructure_event_store = $this->getMockBuilder( \App\EventStore\EventStore::class)
            ->disableOriginalConstructor()->getMock();
        
        $stub_id_generator = $this->getMockBuilder(\App\EventStore\IDGenerator::class)->getMock();
        $stub_id_generator->method('generate')->willReturn("87484542-4a35-417e-8e95-5713b8f55c8e");
        
        $stub_datetime_generator = $this->getMockBuilder(\App\EventStore\DateTimeGenerator::class)->getMock();
        $stub_datetime_generator->method('generate')->willReturn('2014-10-10 12:12:12');
        
        $this->event_builder = new \App\EventStore\EventBuilder($stub_id_generator, $stub_datetime_generator);
        
        $this->event_store = new EventStore($this->infrastructure_event_store, $this->event_builder);
        
        $this->interpreter_event = (object)[
            "schema"=> (object)[
                'id'=>'9be14fd0-80aa-4e82-bd30-df031a51f626',
                'aggregate_id'=>'01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "command_id" => "88f2ecaa-81dd-467f-851d-cdd214f3f3bb",
                "aggregate_id"=> "ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'payload'=> (object)['data'=>true]
            ]
        ];
    }
    
    public function test_translates_event_before_storing_it()
    {
        $event = $this->interpreter_event;
        $this->event_builder->set_aggregate_id($event->domain->aggregate_id)       
                ->set_command_id($event->domain->command_id)
                ->set_schema_event_id($event->schema->id)
                ->set_schema_aggregate_id($event->schema->aggregate_id)
                ->set_payload($event->domain->payload);

        $transformed_event = $this->event_builder->build();
        
        $this->infrastructure_event_store->expects($this->once())
                 ->method('store')
                 ->with($this->equalTo([$transformed_event]));
        
        $this->event_store->store([$this->interpreter_event]);
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