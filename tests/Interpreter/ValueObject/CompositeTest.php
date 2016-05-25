<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;
use App\Interpreter\Context\PropertyException;

class CompositeTest extends AbstractTest
{
    protected function ast_file_path()
    {
        return 'tests/Interpreter/asts/valueobject-composite.json';
    }
    
    public function test_build()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');
        $context = $context->set_property('max', '5');

        $value = $this->interpreter->interpret($context);
        
        $expected = ['min'=>1, 'max'=>5];
        
        $this->assertEquals((object)$expected, $value);
    }
    
    public function test_fail_if_value_wrong()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');
        $context = $context->set_property('max', 'dasdasDdaSDasd');

        $this->setExpectedException(ValueObject\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
    
    public function test_fails_if_key_missing()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');

        $this->setExpectedException(PropertyException::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
