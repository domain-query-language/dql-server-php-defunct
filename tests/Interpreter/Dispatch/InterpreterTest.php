<?php namespace Test\Interpreter\Dispatch;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Command;
use Infrastructure\App\Interpreter\Dispatch;
use App\Interpreter\InvariantException;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $dispatch_interpreter;
    private $event_store;

    public function setUp()
    {
        parent::setUp();
        
        $factory = $this->app->make(Command\Factory::class);
        $command_interpreter = $factory->ast($this->ast_repo->command());
        
        $this->event_store = $this->event_store = $this->app->make(\Infrastructure\App\EventStore\EventStore::class);
        $this->event_store->clear();
        
        $this->dispatch_interpreter = $this->app->make(Dispatch\Interpreter::class);
        
        $context = new Context((object)[
            'id' => "2ea22141-89f4-4216-88f6-81a67cb20d20",
            "payload" => (object)[
                'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
            ]
        ]);
        
        $command = $command_interpreter->interpret($context);
        
        $this->context = new Context($command);
    }
            
    public function test_events_are_sent_to_event_store()
    {
        $events = $this->dispatch_interpreter->interpret($this->context);
        
        $this->assertEquals($events, $this->event_store->fetch('', ''));
    }
    
    public function test_that_events_are_loaded_from_the_stream_and_replayed_to_build_state()
    {        
        $this->dispatch_interpreter->interpret($this->context);
        
        $this->setExpectedException(InvariantException::class);
        
        // This command has been run once, if the events are replayed successfully, 
        // then replaying it again will break it
        $this->dispatch_interpreter->interpret($this->context);
    } 
}
