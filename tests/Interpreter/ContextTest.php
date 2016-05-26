<?php namespace Test\Interpreter;

use App\Interpreter\Context;

class ContextTest extends TestCase
{
    public function test_can_be_created_from_an_object()
    {
        $obj = (object)['value'=>true];
        $context = new Context($obj);
        $this->assertTrue($context->get_property('value'));
    }
    
    public function test_can_be_created_from_an_array()
    {
        $obj = ['value'=>true];
        $context = new Context($obj);
        $this->assertTrue($context->get_property('value'));
    }
   
    public function test_access_property_as_array()
    {
        $obj = (object)['value'=>(object)['child'=>true]];
        $context = new Context($obj);
        $this->assertTrue($context->get_property(['value', 'child']));
    }
    
    public function test_root_is_checked_if_property_is_not_found()
    {
        $obj = (object)['root'=>(object)['value'=>true]];
        $context = new Context($obj);
        $this->assertTrue($context->get_property('value'));
    }
}