<?php namespace Test\Interpreter\Apply;

use Infrastructure\App\Interpreter\Apply;
use App\Interpreter\Context;

class InterpreterTest extends \Test\Interpreter\TestCase
{
    private $apply_factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $this->apply_factory = $this->app()->make(Apply\Factory::class);
        $ast = $this->ast_repo->apply();
        $this->interpreter = $this->apply_factory->ast($ast);     
    }
    
    public function test_creates_event()
    {
        $expected = (object)[
            'id'=>'9be14fd0-80aa-4e82-bd30-df031a51f626', 
            'payload'=> new \stdClass()
        ];
        
        $context = new Context();
        
        $this->assertEquals($expected, $this->interpreter->interpret($context));
    }
}
