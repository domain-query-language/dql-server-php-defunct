<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;

class SimpleTest extends \Test\TestCase
{
    private $ast;
    private $interpreter;
    
    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/ValueObject/simple-ast.json');
        $factory = $this->app()->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($ast);
    }
    
    public function test_build()
    {
        $context = new Context();
        $context = $context->set_property('value', 1);

        $value = $this->interpreter->interpret($context);
        
        $this->assertEquals(1, $value);
    }
    
    public function test_fail()
    {
        $context = new Context();
        $context = $context->set_property('value', -1);

        $this->setExpectedException(ValueObject\Exception::class);
        
        $value = $this->interpreter->interpret($context);
        
        $this->assertEquals(1, $value);
    }
}
