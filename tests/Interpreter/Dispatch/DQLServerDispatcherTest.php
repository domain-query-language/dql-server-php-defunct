<?php namespace Test\Interpreter\Dispatch;

use App\DQLServer\Command;
use App\Interpreter\Dispatch;

class DQLServerDispatcherTest extends \Test\Interpreter\TestCase
{
    private $mock_event_locker;
    private $mock_transformer;
    private $command;
    private $dispatcher;

    public function setUp()
    {
        parent::setUp();
        
        $this->mock_event_locker = $this->getMockBuilder(Dispatch\EventLockerDispatcher::class)
            ->disableOriginalConstructor()->getMock();
        
        $this->mock_transformer = $this->getMockBuilder(\App\Interpreter\Command\Interpreter::class)
            ->disableOriginalConstructor()->getMock();
        
        $this->dispatcher = new Dispatch\DQLServerDispatcher(
            $this->mock_event_locker,
            $this->mock_transformer
        );
        
        $command_id = "2af65a9c-5a1d-46d0-b2be-5a102da14cab";
        $aggregate_id = "2ea22141-89f4-4216-88f6-81a67cb20d20";
        $payload = (object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ];
        
        $this->command = new Command($command_id, $aggregate_id, $payload);
    }
            
    public function test_transforms_event()
    {
        
    }
    
    public function test_passes_through_to_dispatcher()
    {        
        
    } 
}
