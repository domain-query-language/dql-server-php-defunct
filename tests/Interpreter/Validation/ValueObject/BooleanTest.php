<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\ValueObject;

class BooleanTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_boolean();
    }
    
    public function test_build()
    {
        $value = $this->interpreter->validate(true);
        
        $this->assertTrue($value);
    }
    
    public function test_fail()
    {
        $this->setExpectedException(ValueObject\ValueException::class);
        
        $this->interpreter->validate('incorrect string');
    }
}
