<?php namespace Test\Interpreter\Apply;

use Infrastructure\App\Interpreter\Apply;
use App\Interpreter\Context;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $apply_factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $this->apply_factory = $this->app()->make(Apply\Factory::class);
        $ast = $this->ast_repo->apply();
        $this->interpreter = $this->apply_factory->ast($ast);     
    }
    
    public function test_creates_event()
    {
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
        
        $context = new Context((object)[
            'root' => (object)['id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378"]
        ]);
        
        $this->assertEquals($expected, $this->interpreter->interpret($context));
    }
    
    public function test_updates_context()
    {
        $ast = $this->ast_repo->apply_arguments();
        $interperter = $this->apply_factory->ast($ast);
        
        $root = (object)[
            'id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378", 
            'is_created'=>false
        ];
        $command = (object)['shopper_id'=>'81ae684c-8f7a-4e31-8948-bedf4935b3ce'];
        
        $context = new Context((object)[
            'root' => $root,
            'command'=>$command
        ]);
        
        $interperter->interpret($context);
        
        $this->assertTrue($root->is_created);
    }
}
