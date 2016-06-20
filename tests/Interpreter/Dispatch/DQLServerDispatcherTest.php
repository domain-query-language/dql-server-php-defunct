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
        
        $this->mock_event_locker = $this->prophesize(Dispatch\EventLockerDispatcher::class);
        
        $this->mock_transformer = $this->prophesize(\App\Interpreter\Command\Factory::class);
        
        $this->dispatcher = new Dispatch\DQLServerDispatcher(
            $this->mock_event_locker->reveal(),
            $this->mock_transformer->reveal()
        );
        
        $command_id = "2af65a9c-5a1d-46d0-b2be-5a102da14cab";
        $aggregate_id = "2ea22141-89f4-4216-88f6-81a67cb20d20";
        $payload = (object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ];
        
        $this->command = new Command($command_id, $aggregate_id, $payload);
    }
           
    public function test_transforms_and_forwards_command()
    {      
        $transformed_command = 'command';
        
        $this->mock_transformer->dql_command($this->command)
            ->shouldBeCalled()
            ->willReturn($transformed_command);
        
        $this->mock_event_locker->dispatch($transformed_command)
            ->shouldBeCalled();
        
        $this->dispatcher->dispatch($this->command);
    } 
}
