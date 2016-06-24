<?php namespace Test\Interpreter\Handler\Apply;

use App\Interpreter\Handler\Apply;

class InterpreterApplyOnInvariantTest extends \Test\Interpreter\TestCase
{
    private $apply_factory;
    private $interpreter;
    
    public function setUp()
    {
        parent::setUp();
        $this->apply_factory = $this->app->make(Apply\Factory::class);
        $ast = $this->fake_ast_repo->apply_invariant();
        $this->interpreter = $this->apply_factory->ast($ast);     
    }
    
    public function test_creates_event_if_invariant_passes()
    {        
        $root = (object)[
            'id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378",
            'is_created' => false 
        ];
       
        $event = $this->interpreter->interpret($root, []);
        $this->assertNull($event);
    }
    
    public function test_does_not_create_event_if_invariant_fails()
    {
        $root = (object)[
            'id'=>"ff3a666b-4288-4ecd-86d7-7f511a2fd378",
            'is_created' => true 
        ];
        
        $event = $this->interpreter->interpret($root, []);
        $this->assertTrue(is_object($event));
    }
}
