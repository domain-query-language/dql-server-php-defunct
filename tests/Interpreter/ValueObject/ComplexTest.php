<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;

class ComplexTest extends AbstractTest
{    
    protected function ast_file_path()
    {
        return 'tests/Interpreter/ValueObject/complex-ast.json';
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

        $this->setExpectedException(ValueObject\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
