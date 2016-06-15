<?php namespace Test\Interpreter\Modification;

use App\Interpreter\Modification\Interpreter;

class EventHandlerTest extends \Test\Interpreter\TestCase
{
    public function test_adds_to_array()
    {
        $ast = $this->ast_repo->event_handler_add_to_collection();
        $interpreter = new Interpreter($ast->statements);
        
        $root = (object)['list'=>[]];
        $event = (object)['value'=>'hello'];
        
        $expected = (object)['list'=>['hello']];
        $actual = $interpreter->modify($root, $event);
        
        $this->assertEquals($expected, $actual);
    }
    
    public function test_removes_entity_from_array_by_id()
    {
        $ast = $this->ast_repo->event_handler_remove_from_collection();
        $interpreter = new Interpreter($ast->statements);
        
        $id = '722a4a3f-96be-4ed3-b662-043cf8f8d4df';
        $entity = (object)['id'=>$id, 'data'=>true];
        $root = (object)['list'=>[$entity]];
        
        $entity->data = false;
        $event = (object)['entity_id'=>$id];
        
        $expected = (object)['list'=>[]];
        $actual = $interpreter->modify($root, $event);
        
        $this->assertEquals($expected, $actual);
    }
} 