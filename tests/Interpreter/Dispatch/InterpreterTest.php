<?php namespace Test\Interpreter\Dispatch;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Command;
use Infrastructure\App\Interpreter\Dispatch;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $command_interpreter;
    private $dispatch_interpreter;

    public function setUp()
    {
        parent::setUp();
        
        $factory = $this->app()->make(Command\Factory::class);
        $this->command_interpreter = $factory->ast($this->ast_repo->command());
        
        $this->dispatch_interpreter = $this->app()->make(Dispatch\Interpreter::class);
    }
        
    public function test_build()
    {    
        $context = new Context((object)[
            'id' => "2ea22141-89f4-4216-88f6-81a67cb20d20",
            "payload" => (object)[
                'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
            ]
        ]);
        
        $command = $this->command_interpreter->interpret($context);
        
        $dispatch_context = new Context($command);
        
        $events = $this->dispatch_interpreter->interpret($dispatch_context);
        
        $this->assertEquals(1, count($events));
    }
}
