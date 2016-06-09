<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\ValueObject;
use App\Interpreter\ValueObject\PropertyException;

class CompositeTest extends AbstractTest
{
    protected function ast()
    {
        return $this->ast_repo->valueobject_composite();
    }
    
    public function test_build()
    {
        $expected = ['min'=>1, 'max'=>5];
        
        $value = $this->interpreter->validate($expected);
                
        $this->assertEquals((object)$expected, $value);
    }
    
    public function test_fail_if_value_wrong()
    {
        $expected = ['min'=>1, 'max'=>'dasdasDdaSDasd'];
        
        $this->setExpectedException(ValueObject\ValueException::class);
        
        $value = $this->interpreter->validate($expected);
    }
    
    public function test_fails_if_key_missing()
    {
        $context = ['min'=> '1'];
       
        $this->setExpectedException(PropertyException::class);
        
        $value = $this->interpreter->validate($context);
    }
    
    public function test_accepts_array_or_object()
    {
        $expected = (object)['min'=>1, 'max'=>5];
        
        $value = $this->interpreter->validate($expected);
                
        $this->assertEquals($expected, $value);
    }
    
    public function test_it_strips_unused_keys()
    {
        $array = ['min'=>1, 'max'=>5, 'invalid_key'=>'who cares'];
        
        $value = $this->interpreter->validate($array);
        
        $expected = (object)['min'=>1, 'max'=>5];
        $this->assertEquals($expected, $value);
    }
}
