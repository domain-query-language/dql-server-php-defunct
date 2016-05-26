<?php namespace Test\Interpreter\CommandHandler;

use Test\Interpreter\InvariantRepository;
use App\Interpreter\Context;
use App\Interpreter\InvariantException;
use Infrastructure\App\Interpreter\Handler;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    protected $interpreter;
    
    public function setUp()
    {
        parent::setUp();

        $this->app()->bind(\PDO::class, MockPDO::class);
        $this->app()->bind(\App\Interpreter\InvariantRepository::class, InvariantRepository::class);
                
        $event =  $expected = (object)[
            'id'=>'9be14fd0-80aa-4e82-bd30-df031a51f626', 
            'payload'=> new \stdClass()
        ];
        $this->expected_events = [$event, $event];
        
        $handler_factory = $this->app()->make(Handler\Factory::class);
        $ast = $this->ast_repo->handler();
        $this->interpreter = $handler_factory->ast($ast);
    }
     
    private function command()
    {
        $command = new \stdClass();
        $command->aggregate_id = '9d3ee092-9ae2-4e31-9d34-14636635645e';
        $command->shopper_id = '1d0aa941-6dd5-472c-9020-f2cf4caf45ea';
        return $command;
    }
    
    private function context()
    {
        return new Context((object)[
            'command' => $this->command(),
            'root' => (object)[
                'is_created' => false
            ]
        ]);
    }
    
    public function test_interpreter_fires_events()
    {
        $events = $this->interpreter->interpret($this->context());    
        $this->assertEquals($this->expected_events, $events);  
    }
    
    public function test_interpreter_fails_on_invariants()
    {
        $this->setExpectedException(InvariantException::class);
        
        $root = (object)[
            'is_created' => true
        ];
        $context = $this->context()->set_property('root', $root);
      
        $this->interpreter->interpret($context);
    }    
}
