<?php namespace Test\Interpreter;

use Infrastructure\App\Interpreter\CommandStore;

class CommandStoreTest extends TestCase
{
    private $infrastructure_store;
    private $builder;
    private $store;
    private $command;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->infrastructure_store = $this->getMockBuilder( \App\CommandStore\CommandStore::class)
            ->disableOriginalConstructor()->getMock();
        
        $stub_id_generator = $this->getMockBuilder(\App\CommandStore\IDGenerator::class)->getMock();
        $stub_id_generator->method('generate')->willReturn("87484542-4a35-417e-8e95-5713b8f55c8e");
        
        $this->builder = new \App\CommandStore\CommandBuilder($stub_id_generator);
        
        $this->store = new CommandStore($this->infrastructure_store, $this->builder);
        
        $this->command = (object)[
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
        $command = $this->command;
        $this->builder->set_aggregate_id($command->domain->aggregate_id)
                    ->set_schema_event_id($command->schema->id)
                    ->set_schema_aggregate_id($command->schema->aggregate_id)
                    ->set_payload($command->domain->payload);
        
        $transformed = $this->builder->build();
        
        $this->infrastructure_store->expects($this->once())
                 ->method('store')
                 ->with($this->equalTo([$transformed]));
        
        $this->store->store([$this->interpreter]);
    }
        
    public function test_fetch()
    {   
        $stream = ['command'];
        
        $this->infrastructure_store->expects($this->once())
                 ->method('fetch_all')
                ->willReturn($stream);
        
        $this->assertEquals(
            $stream,
            $this->store->fetch_all()
        );      
    }
}