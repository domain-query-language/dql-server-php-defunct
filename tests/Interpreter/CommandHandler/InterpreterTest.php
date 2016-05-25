<?php namespace Test\Interpreter\CommandHandler;

use App\Interpreter\InvariantRepository;
use App\Interpreter\Context;
use App\Interpreter\InvariantException;
use Infrastructure\App\Interpreter\Handler;
use Test\Interpreter\CommandHandler\InvariantRepository\Pass;
use Test\Interpreter\CommandHandler\InvariantRepository\Fail;
use Test\Interpreter\Projection\MockPDO;

class InterpreterTest extends \Test\TestCase
{
    protected $ast;
    
    public function setUp()
    {
        $this->ast = $this->ast();
        
        $event = new \stdClass();
        $event->id = 'event_id';
        $this->expected_events = [$event, $event];
        
        $this->app()->bind(\PDO::class, MockPDO::class);
    }
    
    private function ast()
    {
        return $this->load_json('tests/Interpreter/asts/handler.json');
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
        $context = $context->set_property('is_checked_out', true);
        return $context;
    }
    
    /**
     * @return Interpreter
     */
    protected function make_fires_events_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, Pass::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return $handler_factory->ast($this->ast);
    }
    
    public function test_interpreter_fires_events()
    {
        $interpreter = $this->make_fires_events_interpreter();
        $events = $interpreter->interpret($this->context());    
        $this->assertEquals($this->expected_events, $events);  
    }
    
    /**
     * @return Interpreter
     */
    protected function make_fails_on_invariants_interpreter()
    {
        $this->app()->bind(InvariantRepository::class, Fail::class);
        $handler_factory = $this->app()->make(Handler\Factory::class);
        return $handler_factory->ast($this->ast);
    }
    
    public function test_interpreter_fails_on_invariants()
    {
        $this->setExpectedException(InvariantException::class);
        $interpreter = $this->make_fails_on_invariants_interpreter();
        $interpreter->interpret($this->context());
    }    
}
