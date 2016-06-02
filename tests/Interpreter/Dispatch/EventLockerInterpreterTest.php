<?php namespace Test\Interpreter\Dispatch;

use App\Interpreter\Context;
use App\Interpreter\InvariantException;
use Infrastructure\App\Interpreter\EventLockerDispatch;
use App\EventStore\StreamID;

class EventLockerInterpreterTest extends \Test\Interpreter\TestCase
{
    private $mock_dispatch_interpreter;
    private $mock_locker;
    private $event_locker_dispatcher;
    private $context;
    private $stream_id;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->mock_dispatch_interpreter = $this->getMockBuilder(\App\Interpreter\Dispatch\Interpreter::class)
            ->disableOriginalConstructor()->getMock();
        $this->mock_locker = $this->getMockBuilder(\App\EventStore\EventStreamLocker::class)
            ->disableOriginalConstructor()->getMock();
        
        $this->event_locker_dispatcher = new EventLockerDispatch(
            $this->mock_locker,
            $this->mock_dispatch_interpreter
        );
             
        $this->context = new Context((object)[
            "schema"=>(object)["aggregate_id"=>'s'],
            "domain"=>(object)["aggregate_id"=>'d']
        ]);
        
        $this->stream_id = new StreamID("s", "d");
    }
            
    public function test_calls_lock_and_unlock()
    {        
        $this->mock_locker->expects($this->once())
                 ->method('lock')
                 ->with($this->equalTo($this->stream_id));
        
        $this->mock_locker->expects($this->once())
                 ->method('unlock')
                 ->with($this->equalTo($this->stream_id));
        
        $this->event_locker_dispatcher->interpret($this->context);
    }
    
    public function test_unlocks_if_there_is_an_error()
    {
        $this->mock_dispatch_interpreter->method('interpret')
                ->will($this->throwException(new InvariantException));
        
        $this->mock_locker->expects($this->once())
                 ->method('unlock')
                 ->with($this->equalTo($this->stream_id));
        
        $this->setExpectedException(InvariantException::class);
        
        $this->event_locker_dispatcher->interpret($this->context);
    }
}
