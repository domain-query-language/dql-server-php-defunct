<?php namespace Test\Interpreter\Validation\ValueObject;

use App\Interpreter\Validation\ValueObject;

class CollectionTest extends AbstractTest
{
    protected function ast()
    {
        return $this->fake_ast_repo->valueobject_collection();
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
    
    private function make_invariant_collection_interpreter()
    {
        $ast = $this->fake_ast_repo->invariant_collection();
        return $this->factory->ast($ast);
    }
    
    public function test_exists_in_for_valueobjects()
    {
        $interpreter = $this->make_invariant_collection_interpreter();
        
        $list = (object)['list'=>[1, 2]];
        
        $this->assertTrue($interpreter->check($list, (object)['entity_id'=>1]));
        $this->assertFalse($interpreter->check($list, (object)['entity_id'=>-1])); 
    }
    
    public function test_fails_on_empty_list()
    {
        $interpreter = $this->make_invariant_collection_interpreter();
        
        $list = (object)['list'=>[]];
        
        $this->assertFalse($interpreter->check($list, (object)['entity_id'=>1]));
    }
    
    public function test_exists_in_for_entity()
    {
        $interpreter = $this->make_invariant_collection_interpreter();
        
        $list = (object)['list'=>[
            (object)['id'=>'ab3b3205-a52c-47bc-b9dd-00902035c080'],
            (object)['id'=>'0b0dedf3-c5ee-44ca-b3c1-40453b81c5d0']
        ]];
        
        $true_args = (object)['entity_id'=>'ab3b3205-a52c-47bc-b9dd-00902035c080'];
        $this->assertTrue($interpreter->check($list, $true_args));
        
        $false_args = (object)['entity_id'=>'6c33c3b3-f37f-446e-b4a0-b8d3664760f6'];
        $this->assertFalse($interpreter->check($list, $false_args)); 
    }
    
    private function make_invariant_collection_legnth_interpreter()
    {
        $ast = $this->fake_ast_repo->invariant_collection_length();
        return $this->factory->ast($ast);
    }
    
    public function test_length_of_collection()
    {
        $interpreter = $this->make_invariant_collection_legnth_interpreter();
        $list = (object)['list'=>[]];
        
        $this->assertTrue($interpreter->check($list));
        
        $list->list[] = 1;
        $this->assertFalse($interpreter->check($list));
    }
}
