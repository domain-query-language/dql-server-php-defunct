<?php namespace Test\Interpreter\Handler\CommandHandler;

use App\Interpreter\Handler\Invariant;
use App\Interpreter\Handler;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    protected $interpreter;
    
    public function setUp()
    {
        parent::setUp();
                                
        $handler_factory = $this->app->make(Handler\Factory::class);
        $ast = $this->fake_ast_repo->fetch("2af65a9c-5a1d-46d0-b2be-5a102da14cab");
        $this->interpreter = $handler_factory->ast($ast);
    }
     
    private function command()
    {
        $command = new \stdClass();
        $command->aggregate_id = '9d3ee092-9ae2-4e31-9d34-14636635645e';
        $command->shopper_id = '1d0aa941-6dd5-472c-9020-f2cf4caf45ea';
        return $command;
    }
    
    private function root()
    {
        return (object)[
            'id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378",
            'is_created' => false
        ];
    }
    
    public function test_interpreter_fires_events()
    {
        $events = $this->interpreter->handle($this->root(), $this->command());    
        $this->assertEquals(1, count($events));  
    }
    
    public function test_interpreter_fails_on_invariants()
    {
        $this->setExpectedException(Invariant\Exception::class);
        
        $root = $this->root();
        $root->is_created = true;
      
        $this->interpreter->handle($root, $this->command());
    }    
}
