<?php namespace Test\Interpreter\Aggregate;

use App\Interpreter\Aggregate;

class AggregateTest extends \Test\Interpreter\TestCase
{
    private $event_store;
    private $aggregate;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->event_store = $this->app->make(\App\Interpreter\EventStore::class);
                
        $this->aggregate = $this->app->make(Aggregate\Aggregate::class);
   
        $this->id = "e5cbb69e-4581-4095-b77c-2e9eb1c8af17";
        $this->entity_id = "2ea22141-89f4-4216-88f6-81a67cb20d20";
    }
        
    public function test_builds_root_entity()
    {
        $entity = $this->aggregate->build_root($this->id, $this->entity_id);
        
        $expected = (object)[
            'id' => '2ea22141-89f4-4216-88f6-81a67cb20d20',
            'is_created' => false
        ];
        
        $this->assertEquals($expected, $entity);
    }
    
    public function test_replays_events_on_root_entity()
    {
        $event = (object)[
            "schema"=> (object)[
                'id'=>'3961fd8c-a054-41e1-a998-3fc9cfd8f0ad',
                'aggregate_id'=>'01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "aggregate_id"=> "ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'payload'=> new \stdClass()
            ]
        ];
        
        $this->event_store->store([$event]);
        
        $entity = $this->aggregate->build_root($this->id, $this->entity_id);
        
        $expected = (object)[
            'id' => '2ea22141-89f4-4216-88f6-81a67cb20d20',
            'is_created' => true
        ];
        
        $this->assertEquals($expected, $entity);
    }
}
