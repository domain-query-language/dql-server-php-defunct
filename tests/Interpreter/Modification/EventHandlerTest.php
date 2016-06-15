<?php namespace Test\Interpreter\Modification;

use App\Interpreter\Modification\Interpreter;

class EventHandlerTest extends \Test\Interpreter\TestCase
{    
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $ast = $this->ast_repo->event_handler_collection();
        $this->interpreter = new Interpreter($ast->statements);
    }
    
    public function test_adds_to_array()
    {
        $root = (object)['list'=>[]];
        $event = (object)['value'=>'hello'];
        
        $expected = (object)['list'=>['hello']];
        $actual = $this->interpreter->modify($root, $event);
        
        $this->assertEquals($expected, $actual);
    }
} 