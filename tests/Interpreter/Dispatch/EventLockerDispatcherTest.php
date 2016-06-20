<?php namespace Test\Interpreter\Dispatch;

use App\Interpreter\Handler\Invariant;
use App\Interpreter\Dispatch\EventLockerDispatcher;
use App\EventStore\StreamID;

class EventLockerDispatcherTest extends \Test\Interpreter\TestCase
{
    private $stub_dispatch_interpreter;
    private $mock_locker;
    private $event_locker_dispatcher;
    private $command;
    private $stream_id;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->stub_dispatch_interpreter = $this->stub(\App\Interpreter\Dispatch\Dispatcher::class);
        $this->mock_locker = $this->mock(\App\EventStore\EventStreamLocker::class);
        
        $this->event_locker_dispatcher = new EventLockerDispatcher(
            $this->mock_locker->reveal(),
            $this->stub_dispatch_interpreter->reveal()
        );
             
        $this->command = (object)[
            "schema"=>(object)["aggregate_id"=>'s'],
            "domain"=>(object)["aggregate_id"=>'d']
        ];
        
        $this->stream_id = new StreamID("s", "d");
    }
            
    public function test_calls_lock_and_unlock()
    {        
        $this->mock_locker->lock($this->stream_id)
            ->shouldBeCalled();
        
        $this->mock_locker->unlock($this->stream_id)
            ->shouldBeCalled();
        
        $this->event_locker_dispatcher->dispatch($this->command);
    } 
    
    public function test_unlocks_if_there_is_an_error()
    {
        $this->mock_locker->lock($this->stream_id)
            ->shouldBeCalled();
        
        $this->stub_dispatch_interpreter->dispatch($this->command)
            ->willThrow(new Invariant\Exception);
        
        $this->mock_locker->unlock($this->stream_id)
            ->shouldBeCalled();
        
        $this->setExpectedException(Invariant\Exception::class);
        
        $this->event_locker_dispatcher->dispatch($this->command);
    }
}
