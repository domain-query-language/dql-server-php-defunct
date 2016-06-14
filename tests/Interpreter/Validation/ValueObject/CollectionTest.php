<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\Validation\ValueObject;

class CollectionTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_collection();
    }
    
    public function test_build()
    {
        $expected = [1, 2];
        
        $actual = $this->interpreter->validate($expected);
                
        $this->assertEquals($expected, $actual);
    }
    
    public function test_fail_if_value_is_wrong()
    {
        $expected = [1, -1];
        
        $this->setExpectedException(ValueObject\ValueException::class);
        
        $this->interpreter->validate($expected);
    }
    
    public function test_checking_values()
    {
        $this->assertTrue($this->interpreter->check([1, 2]));
        $this->assertFalse($this->interpreter->check([1, -2]));
    }
    
    public function test_accepts_empty_arrays()
    {
        $expected = [];
        
        $actual = $this->interpreter->validate($expected);
        
        $this->assertEquals($expected, $actual);
    }
}
