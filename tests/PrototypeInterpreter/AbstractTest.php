<?php

require_once "EventStore.php";

use App\Interpreter\Interpreter;

//PrototypeInterpreter
abstract class AbstractTest extends TestCase
{   
    protected $ast;
    protected $event_store;
    
    public function setUp()
    {
        $this->ast = $this->ast();
        $this->event_store = $this->event_store();
    }
    
    private function ast()
    {
        $ast_file = base_path('tests/PrototypeInterpreter/ast.json');
        return json_decode(file_get_contents($ast_file));
    }
    
    private function event_store()
    {
        return new EventStore();
    }
    
    /**
     * @return Interpreter
     */
    abstract protected function build_fires_events_interpreter();
    
    private function command()
    {
        $command = new stdClass();
        $command->aggregate_id = '9d3ee092-9ae2-4e31-9d34-14636635645e';
        $command->shopper_id = '1d0aa941-6dd5-472c-9020-f2cf4caf45ea';
        return $command;
    }
    
    private function context()
    {
        $context = new stdClass();
        $context->command = $this->command();
        return $context;
    }
   
    public function test_interpreter_fires_events()
    {
        $interpreter = $this->build_fails_on_invariants_interpreter();
        
        $interpreter->interpret($this->context());
        
        $this->assert($this->expected_events, $this->event_store->events());
        
    }
    
    /**
     * @return Interpreter
     */
    abstract protected function build_fails_on_invariants_interpreter();
    
    public function test_interpreter_fails_on_invariants()
    {
        $this->setExpectedException(\InvariantException::class);
        
        $interpreter = $this->build_fails_on_invariants_interpreter();
        
        $interpreter->interpret($this->context());
    }
}


