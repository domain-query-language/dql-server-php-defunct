<?php namespace Test\Interpreter\CommandHandler;

require_once "InvariantRepository/Fail.php";
require_once "InvariantRepository/Pass.php";

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;
use App\Interpreter\InvariantException;
use Infrastructure\App\Interpreter\Handler;

class InterpreterTest extends \Test\TestCase
{
    protected $ast;
    
    public function setUp()
    {
        $this->ast = $this->ast();
        
        $event = new \stdClass();
        $event->id = 'event_id';
        $this->expected_events = [$event, $event];
    }
    
    private function ast()
    {
        $ast_file = base_path('tests/Interpreter/CommandHandler/ast.json');
        return json_decode(file_get_contents($ast_file));
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
        $context = new Context();
        $context = $context->set_property('command', $this->command());
        return $context;
    }
    
    /**
     * @return Interpreter
     */
    protected function build_fires_events_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, \Pass::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return $handler_factory->ast($this->ast->handler);
    }
    
    public function test_interpreter_fires_events()
    {
        $interpreter = $this->build_fires_events_interpreter();
        $events = $interpreter->interpret($this->context());    
        $this->assertEquals($this->expected_events, $events);  
    }
    
    /**
     * @return Interpreter
     */
    protected function build_fails_on_invariants_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, \Fail::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return $handler_factory->ast($this->ast->handler);
    }
    
    public function test_interpreter_fails_on_invariants()
    {
        $this->setExpectedException(InvariantException::class);
        $interpreter = $this->build_fails_on_invariants_interpreter();
        $interpreter->interpret($this->context());
    }    
}
