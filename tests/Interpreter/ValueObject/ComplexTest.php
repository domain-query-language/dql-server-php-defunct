<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;
use Infrastructure\App\Interpreter\Validator;

class ComplexTest extends \Test\TestCase
{
    private $interpreter;
    
    public function setUp()
    {
        $ast = $this->load_json('tests/Interpreter/ValueObject/complex-ast.json');
        $factory = $this->app()->make(ValueObject\Factory::class);
        $this->interpreter = $factory->ast($ast);
    }
    
    public function test_build()
    {
        $context = new Context();
        $context = $context->set_property('value', '0fabce80-7364-45ae-aadd-04e3df412e58');

        $value = $this->interpreter->interpret($context);
        
        $this->assertEquals('0fabce80-7364-45ae-aadd-04e3df412e58', $value);
    }
    
    public function test_fail()
    {
        $context = new Context();
        $context = $context->set_property('value', 'dasdasDdaSDasd');

        $this->setExpectedException(Validator\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
