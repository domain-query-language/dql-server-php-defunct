<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Compare;

class CompositeTest extends AbstractTest
{
    protected function ast_file_path()
    {
        return 'tests/Interpreter/ValueObject/composite-ast.json';
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

        $this->setExpectedException(Compare\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
    
    public function test_fails_if_key_missing()
    {
        $context = new Context();
        $context = $context->set_property('min', '1');

        $this->setExpectedException(\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
