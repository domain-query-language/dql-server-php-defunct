<?php namespace Test\Interpreter\ValueObject;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\ValueObject;

class SimpleTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_simple();
    }
    
    public function test_build()
    {
        $context = new Context(['value'=>1]);
       
        $value = $this->interpreter->interpret($context);
        
        $this->assertEquals(1, $value);
    }
    
    public function test_fail()
    {
        $context = new Context(['value'=>-1]);

        $this->setExpectedException(ValueObject\Exception::class);
        
        $this->interpreter->interpret($context);
    }
}
