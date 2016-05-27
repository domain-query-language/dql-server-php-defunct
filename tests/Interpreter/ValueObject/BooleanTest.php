<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;

class BooleanTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_boolean();
    }
    
    public function test_build()
    {
        $context = new Context(['value'=>true]);
       
        $value = $this->interpreter->interpret($context);
        
        $this->assertTrue($value);
    }
    
    public function test_fail()
    {
        $context = new Context(['value'=>0]);

        $this->setExpectedException(ValueObject\Exception::class);
        
        $this->interpreter->interpret($context);
    }
}
