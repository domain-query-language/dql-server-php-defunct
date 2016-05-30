<?php namespace Test\Interpreter\Aggregate;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Aggregate;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $context;
    private $event_store;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->event_store = new \Test\Interpreter\EventStore();
        
        $ast = $this->ast_repo->aggregate();
        
        $factory = $this->app()->make(Aggregate\Factory::class);
        
        $this->interpreter = $factory->ast($ast);
        
        $this->context = new Context((object)[
            'aggregate_id' => "2ea22141-89f4-4216-88f6-81a67cb20d20"]
        );
    }
        
    /*public function test_builds_root_entity()
    {
        $entity = $this->interpreter->interpret($this->context);
        
        $expected = (object)[
            'id' => '2ea22141-89f4-4216-88f6-81a67cb20d20',
            'is_created' => false
        ];
        
        $this->assertEquals($expected, $entity);
    }
     *
     */
    
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
        
        $entity = $this->interpreter->interpret($this->context);
        
        $expected = (object)[
            'id' => '2ea22141-89f4-4216-88f6-81a67cb20d20',
            'is_created' => true
        ];
        
        $this->assertEquals($expected, $entity);
    }
}
