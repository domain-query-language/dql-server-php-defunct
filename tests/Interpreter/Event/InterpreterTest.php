<?php namespace Test\Interpreter\Event;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Event;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $factory;
    private $interpreter;

    public function setUp()
    {
        parent::setUp();
        $this->factory = $this->app->make(Event\Factory::class);
        $this->interpreter = $this->factory->ast($this->ast_repo->event());
    }
    
    public function test_build_empty_event()
    {
        $context = new Context((object)[
            'root' => (object)['id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378"],
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ]);
        $interpreter = $this->factory->ast($this->ast_repo->event_empty());
        $event = $interpreter->interpret($context);
        
        $expected = (object)[
            "schema"=> (object)[
                'id'=>'9be14fd0-80aa-4e82-bd30-df031a51f626',
                'aggregate_id'=>'01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "aggregate_id"=> "ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'payload'=> new \stdClass()
            ]
        ];
        
        $this->assertEquals($expected, $event);
    }
        
    public function test_build_event_with_chldren()
    {
        $context = new Context((object)[
            'root' => (object)['id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378"],
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ]);
        $event = $this->interpreter->interpret($context);
        
        $expected = (object)[
            "schema"=> (object)[
                'id'=>'3961fd8c-a054-41e1-a998-3fc9cfd8f0ad',
                'aggregate_id'=>'01f99d4f-4cc7-4125-96fd-11f7dcbe8f9a'
            ],
            "domain"=> (object)[
                "aggregate_id"=> "ff3a666b-4288-4ecd-86d7-7f511a2fd378",
                'payload'=> (object)[
                    'shopper_id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
                ]
            ]
        ];
  
        $this->assertEquals($expected, $event);
    }
}
