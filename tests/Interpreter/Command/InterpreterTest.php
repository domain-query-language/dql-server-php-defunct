<?php namespace Test\Interpreter\Command;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Command;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $factory;
    private $interpreter;

    public function setUp()
    {
        parent::setUp();
        $this->factory = $this->app()->make(Command\Factory::class);
        $this->interpreter = $this->factory->ast($this->ast_repo->command());
    }
        
    public function test_build()
    {
        $context = new Context((object)[
            'shopper_id' => '7a53bbd2-8919-4bdf-a43c-c330b2f304e6'
        ]);
        $command = $this->interpreter->interpret($context);
        $expected = ['shopper_id'=>'7a53bbd2-8919-4bdf-a43c-c330b2f304e6'];
        
        $this->assertEquals((object)$expected, $command);
    }
}
