<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\ValueObject;

class SimpleTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_simple();
    }
    
    public function test_build()
    {  
        $value = $this->interpreter->validate(1);
        
        $this->assertEquals(1, $value);
    }
    
    public function test_fail()
    {
        $this->setExpectedException(ValueObject\ValueException::class);
        
        $this->interpreter->validate(-1);
    }
}
