<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\Context;
use App\Interpreter\ValueObject;
use App\Interpreter\Context\PropertyException;

class CompositeTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_composite();
    }
    
    public function test_build()
    {
        $expected = ['min'=>1, 'max'=>5];
        $context = new Context($expected);
        
        $value = $this->interpreter->interpret($context);
                
        $this->assertEquals((object)$expected, $value);
    }
    
    public function test_fail_if_value_wrong()
    {
        $expected = ['min'=>1, 'max'=>'dasdasDdaSDasd'];
        $context = new Context($expected);

        $this->setExpectedException(ValueObject\Exception::class);
        
        $value = $this->interpreter->interpret($context);
    }
    
    public function test_fails_if_key_missing()
    {
        $context = new Context(['min'=> '1']);
       
        $this->setExpectedException(PropertyException::class);
        
        $value = $this->interpreter->interpret($context);
    }
}
